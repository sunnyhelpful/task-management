<script>
    const apiUrl = "{{ url('api/tasks') }}";
    let tasks = [];
    let currentPage = 1;
    let isLoading = false;

    /* Start Fetch Data */
    async function fetchTasks(page = 1) {
        if (isLoading) return;
        isLoading = true;

        try {
            const response = await fetch(`${apiUrl}?page=${page}`);
            const data = await response.json();
            tasks = [...tasks, ...data.data.data];
            renderTasks();
            isLoading = false;
            currentPage++;
        } catch (error) {
            console.error("Error fetching tasks:", error);
            isLoading = false;
        }
    }

    function renderTasks(statusFilter = '', searchQuery = '') {
        const taskList = document.getElementById('task-list');
        taskList.innerHTML = '';

        const filteredTasks = tasks.filter(task => {
            const matchesStatus = statusFilter ? task.status === statusFilter : true;
            const matchesSearch = task.title.toLowerCase().includes(searchQuery.toLowerCase());
            return matchesStatus && matchesSearch;
        });

        if(filteredTasks.length > 0){
            filteredTasks.forEach(task => {
                const row = `
                    <tr data-id="${task.id}" id="row-${task.id}">
                        <td>${task.title}</td>
                        <td>${task.description}</td>
                        <td>${task.status}</td>
                        <td>${task.due_date}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm" onclick="editTask('${task.id}')">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm" onclick="deleteTask('${task.id}')">Delete</a>
                            </div>
                        </td>
                    </tr>
                `;
                taskList.innerHTML += row;
            });
        }else{
            taskList.innerHTML += '';
        }
    }

    document.getElementById('status-filter').addEventListener('change', function() {
        const status = this.value;
        const searchQuery = document.getElementById('search-bar').value;
        renderTasks(status, searchQuery);
    });

    document.getElementById('search-bar').addEventListener('input', function() {
        const searchQuery = this.value;
        const status = document.getElementById('status-filter').value;
        renderTasks(status, searchQuery);
    });

    /* End Fetch Data */

    /* Show Modal For Create */
    async function showCreateTaskModal() {
        document.getElementById('task-id').value = '';
        document.getElementById('task-title').value = '';
        document.getElementById('task-description').value = '';
        document.getElementById('task-status').value = 'pending';
        document.getElementById('task-due_date').value = '';
        
        document.getElementById('taskModalLabel').innerText = 'Create Task';
        document.querySelector('button[type="submit"]').innerText = 'Create Task';

        $('#taskModal').modal('show');
    }

    document.getElementById('create-task-button').addEventListener('click', showCreateTaskModal);
    /* End Modal For Create */

    /* Show Modal For edit */
    async function editTask(id) {
        const response = await fetch(`${apiUrl}/${id}`);
        const task = await response.json();
        if (!task || !task.data) {
            toasterAlert('error', 'Unable to edit task: data is missing.');
            return;
        }

        document.getElementById('task-id').value = task.data.data.id;
        document.getElementById('task-title').value = task.data.data.title;
        document.getElementById('task-description').value = task.data.data.description;
        document.getElementById('task-status').value = task.data.data.status;
        document.getElementById('task-due_date').value = task.data.data.due_date;

        document.getElementById('taskModalLabel').innerText = 'Edit Task';
        document.querySelector('button[type="submit"]').innerText = 'Update Task';

        $('#taskModal').modal('show');
    }
    /* End Modal For Edit */


    /* Start create And Edit Functionality */
    document.getElementById('task-form').addEventListener('submit', async (event) => {
        event.preventDefault();
        $('.validation-error-block').remove();

        const id = document.getElementById('task-id').value;
        const title = document.getElementById('task-title').value;
        const description = document.getElementById('task-description').value;
        const status = document.getElementById('task-status').value;
        const due_date = document.getElementById('task-due_date').value;

        const taskData = { title, description, status, due_date };
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}/${id}` : apiUrl;

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(taskData)
            });

            if (!response.ok) {
                const errorResponse = await response.json();
                const errors = errorResponse.errors;
                $.each(errors, function(key, item) {
                    const errorLabel = `<span class="validation-error-block text-danger">${item[0]}</span>`;
                    const inputElement = $("#task-" + key);
                    if (inputElement.length) {
                        inputElement.after(errorLabel);
                    }
                });
            } else {
                const result = await response.json();
                toasterAlert('success', id ? '{{ __('messages.record_updated_successfully') }}' : '{{ __('messages.record_created_successfully') }}');
                fetchTasks();
                $('#taskModal').modal('hide');
            }
        } catch (error) {
            toasterAlert('error', `An error occurred while ${id ? "updating" : "creating"} the task.`);
        }
    });
    /* End */

    /* Start Delete */
    async function deleteTask(id) {
        const result = await Swal.fire({
            title: "{{ trans('global.areYouSure') }}",
            text: "{{ trans('global.onceClickedRecordDeleted') }}",
            icon: "warning",
            showDenyButton: true,
            confirmButtonText: "{{ trans('global.swl_confirm_button_text') }}",
            denyButtonText: "{{ trans('global.swl_deny_button_text') }}",
            allowOutsideClick: false,
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(`${apiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        // 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Uncomment if needed
                    }
                });

                if (response.ok) {
                    fetchTasks();
                    $('#row-' + id).remove();
                    toasterAlert('success', '{{ __('messages.record_deleted_successfully') }}');
                } else {
                    const error = await response.json();
                    toasterAlert('error', error.message);
                }
            } catch (error) {
                console.error("Error deleting task:", error);
                toasterAlert('error', '{{ __('messages.error_message') }}');
            }
        }
    }
    /* End Delete */

    /* Start On close reset the form */
    $('.btnClose').click(function(){
        $(".validation-error-block").remove();
        $('#task-form')[0].reset();
    });
    /* End */

    /* Start On Scroll Fetch */
    $(document).ready(function () {
        $(".common-table").on('scroll', function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
                fetchTasks(currentPage);
            }
        });
    });
    /* End On Scroll Fetch */

    /* Start Sortable */
    $(function() {
        $(".sortable").sortable({
            /* start: function(event, ui) {
                console.log("Sort started");
            },
            stop: function(event, ui) {
                console.log("Sort stopped");
            }, */
            update: function(event, ui) {
                const sortedIDs = $(this).sortable("toArray", { attribute: 'data-id' });
                console.log("New order:", sortedIDs);

                $.ajax({
                    method: 'POST',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{route("tasks.orderStorable")}}',
                    data : {
                        order: sortedIDs
                    },
                    success: function(response) {
                        console.log("Response : ", response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating order:", error);
                    }
                });
            }
        });
        $(".sortable").disableSelection();
        fetchTasks();
    });
    /* End Sortable */

</script>