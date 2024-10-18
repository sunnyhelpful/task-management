<div class="modal fade show" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="taskModalLabel">{{ trans('global.show') }} {{ trans('cruds.task.title_singular') }}</h4>
                <button type="button" class="btn-close btnClose" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="task-form">
                    @csrf
                    <input type="hidden" id="task-id">
                    <div class="form-group">
                        <label for="task-title">{{ trans('cruds.task.title_singular') }}</label>
                        <input type="text" id="task-title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="task-description">{{ trans('cruds.task.fields.description') }}</label>
                        <textarea id="task-description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="task-status">{{ trans('cruds.task.fields.status') }}</label>
                        <select id="task-status" class="form-control">
                            @foreach (config('constant.status') as $key => $item)
                                <option value="{{$key}}">{{ucfirst($item)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="task-due_date">{{ trans('cruds.task.fields.due_date') }}</label>
                        <input type="date" id="task-due_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Task</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnClose" data-bs-dismiss="modal">{{ trans('global.close') }}</button>
            </div>
        </div>
    </div>
</div>