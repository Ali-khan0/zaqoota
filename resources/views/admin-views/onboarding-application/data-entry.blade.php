@if(in_array($application->status, ['data_pending','data_entry','review_pending']) && $application->invoice?->payment_status === 'paid' && !$application->invoice?->voided_at)
<div class="card mb-3"><div class="card-body">
    <h3>{{ translate('Data entry and final review') }}</h3>
    <p>{{ translate('Assigned staff') }}: {{ $application->dataEntryStaff?->email ?? translate('Unassigned') }}</p>
    <p>{{ translate('Completed') }}: {{ $application->data_entry_completed_at ?? '—' }}</p>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a class="btn btn-outline-primary" href="{{ route('admin.store.edit', $application->store_id) }}">{{ translate('Edit store details') }}</a>
        @if(\App\CentralLogics\Helpers::module_permission_check('item'))
            <a class="btn btn-outline-primary" href="{{ route('admin.item.list', ['store_id' => $application->store_id]) }}">{{ translate('Store catalog') }}</a>
            <a class="btn btn-outline-primary" href="{{ route('admin.item.add-new', ['store_id' => $application->store_id]) }}">{{ translate('Add catalog item') }}</a>
        @endif
    </div>
    @if(in_array($application->status, ['data_pending','data_entry']))
        <form method="post" action="{{ route('admin.users.onboarding-applications.data-entry', $application->id) }}" class="mb-3">@csrf
            <input type="hidden" name="action" value="assign"><input type="hidden" name="expected_status" value="{{ $application->status }}">
            @if(\App\CentralLogics\Helpers::module_permission_check('employee'))
                <label>{{ translate('Staff admin ID (your ID is)') }} {{ auth('admin')->id() }}</label><input class="form-control mb-2" name="assignee" type="number" min="1" value="{{ $application->data_entry_admin_id ?? auth('admin')->id() }}" required>
            @else<input type="hidden" name="assignee" value="{{ auth('admin')->id() }}">@endif
            <label>{{ translate('Assignment note') }}</label><input name="note" class="form-control mb-2" required maxlength="2000">
            <button class="btn btn--primary">{{ translate('Assign / claim data entry') }}</button>
        </form>
        @if($application->status === 'data_entry' && (int) $application->data_entry_admin_id === (int) auth('admin')->id())
            <form method="post" action="{{ route('admin.users.onboarding-applications.data-entry', $application->id) }}">@csrf
                <input type="hidden" name="action" value="complete"><input type="hidden" name="expected_status" value="data_entry">
                <label class="d-block"><input type="checkbox" name="store_checked" value="1" required> {{ translate('Store contact, address, photos and delivery settings checked') }}</label>
                <label class="d-block"><input type="checkbox" name="catalog_checked" value="1" required> {{ translate('Catalog, prices and availability checked against the submitted menu') }}</label>
                <label>{{ translate('Completion note') }}</label><textarea name="note" class="form-control mb-2" required maxlength="2000"></textarea>
                <button class="btn btn--primary">{{ translate('Submit for final review') }}</button>
            </form>
        @endif
    @elseif(\App\CentralLogics\Helpers::module_permission_check('report'))
        <form method="post" action="{{ route('admin.users.onboarding-applications.approve', $application->id) }}">@csrf
            <p>{{ translate('Final approval activates the partner and sends the password setup email.') }}</p>
            <button class="btn btn--primary">{{ translate('Approve and activate partner') }}</button>
        </form>
    @endif
</div></div>
@endif
