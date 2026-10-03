@extends('layouts.admin.app')

@section('title', 'Onboarding Managers')

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h1 class="page-header-title mb-1">
                    <span class="page-header-icon"><i class="tio-briefcase"></i></span>
                    <span>Onboarding managers</span>
                </h1>
                <p class="text-muted mb-0">Manage Zaqoota Ops access, territory, commission and performance.</p>
            </div>
            <a href="{{ route('admin.users.employee.add-new', ['staff_type' => 'onboarding_manager']) }}" class="btn btn--primary">
                <i class="tio-add-circle"></i> Add onboarding manager
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            ['label' => 'Managers', 'value' => $summary['total'], 'class' => 'primary'],
            ['label' => 'Active access', 'value' => $summary['active'], 'class' => 'success'],
            ['label' => 'Applications', 'value' => $summary['applications'], 'class' => 'info'],
            ['label' => 'Approved stores', 'value' => $summary['approved'], 'class' => 'warning'],
        ] as $item)
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body">
                        <span class="text-muted">{{ $item['label'] }}</span>
                        <h2 class="text-{{ $item['class'] }} mb-0 mt-2">{{ number_format($item['value']) }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header border-0">
            <form method="get" class="w-100">
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="input-label">Search manager</label>
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Name, email or phone">
                    </div>
                    <div class="col-md-3">
                        <label class="input-label">Ops access</label>
                        <select name="status" class="form-control">
                            <option value="all">All</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="btn--container">
                            <button class="btn btn--primary" type="submit"><i class="tio-search"></i> Filter</button>
                            <a class="btn btn--reset" href="{{ route('admin.users.onboarding-manager.index') }}">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                <thead class="thead-light">
                    <tr>
                        <th>Manager</th>
                        <th>Territory</th>
                        <th>Commission</th>
                        <th>Performance</th>
                        <th>Ops access</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($managers as $manager)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img class="avatar avatar-sm rounded-circle onerror-image" src="{{ $manager->image_full_url }}"
                                         data-onerror-image="{{ asset('/public/assets/admin/img/admin.png') }}" alt="">
                                    <div>
                                        <strong>{{ trim($manager->f_name.' '.$manager->l_name) }}</strong>
                                        <div class="text-muted small">{{ $manager->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $manager->zones?->name ?? 'All territories' }}</td>
                            <td>{{ number_format((float) $manager->onboarding_commission_percent, 2) }}%</td>
                            <td>
                                <strong>{{ $manager->approved_applications_count }}</strong> approved
                                <div class="text-muted small">{{ $manager->onboarding_applications_count }} total</div>
                            </td>
                            <td>
                                <span class="badge badge-soft-{{ $manager->canUseOps() ? 'success' : 'danger' }}">
                                    {{ $manager->canUseOps() ? 'Active' : ($manager->ops_status ? 'Role inactive' : 'Banned') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn-outline-primary" href="{{ route('admin.users.onboarding-manager.show', $manager) }}" title="View">
                                        <i class="tio-visible-outlined"></i>
                                    </a>
                                    <a class="btn action-btn btn-outline-primary" href="{{ route('admin.users.employee.edit', $manager) }}" title="Edit">
                                        <i class="tio-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty--data"><h5>No onboarding managers found.</h5></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($managers->hasPages())
            <div class="card-footer">{{ $managers->links() }}</div>
        @endif
    </div>
</div>
@endsection
