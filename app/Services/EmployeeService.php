<?php

namespace App\Services;

use App\Models\Admin;
use App\Traits\FileManagerTrait;

class EmployeeService
{
    use FileManagerTrait;

    public function getAddData(object $request): array
    {
        return [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'zone_id' => auth('admin')->user()?->zone_id ?? $request->zone_id,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'staff_type' => $request->staff_type,
            'onboarding_commission_percent' => $request->staff_type === Admin::STAFF_TYPE_ONBOARDING_MANAGER
                ? $request->onboarding_commission_percent
                : 0,
            'ops_status' => $request->staff_type === Admin::STAFF_TYPE_ONBOARDING_MANAGER
                ? $request->boolean('ops_status')
                : false,
            'password' => bcrypt($request->password),
            'image' => $this->upload('admin/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function getUpdateData(object $request, object $employee): array
    {
        if ($request['password'] == null) {
            $pass = $employee['password'];
        } else {
            $pass = bcrypt($request['password']);
            $employee->remember_token = null;
            $employee->login_remember_token = null;
        }

        if ($request->has('image')) {
            $employee['image'] = $this->updateAndUpload('admin/', $employee->image, 'png', $request->file('image'));
        }

        return [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'zone_id' => auth('admin')->user()?->zone_id ?? $request->zone_id,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'staff_type' => $request->staff_type,
            'onboarding_commission_percent' => $request->staff_type === Admin::STAFF_TYPE_ONBOARDING_MANAGER
                ? $request->onboarding_commission_percent
                : 0,
            'ops_status' => $request->staff_type === Admin::STAFF_TYPE_ONBOARDING_MANAGER
                ? $request->boolean('ops_status')
                : false,
            'password' => $pass,
            'image' => $employee['image'],
            'updated_at' => now(),
            'is_logged_in' => 0,
        ];
    }

    public function adminCheck(object $employee): array
    {
        if (auth('admin')->id() != $employee['id']) {
            return ['flag' => 'unauthorized'];
        }

        return ['flag' => 'authorized'];
    }
}
