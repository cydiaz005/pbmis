<?php

namespace App\Http\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use App\Models\User;

class UserPermissions extends Component
{
    public $permissions;
    public $user_id;
    public $user;
    public $role;
    

    public function render()
    {
        $this->permissionBuilder();

        return view('livewire.user-permissions');
    }
    public function permissionBuilder()
    {
        $current = User::find($this->user_id);
        $this->user = $current;
        $this->role = $current->roles->take(1)->pluck('name');
        $this->active = $current->getAllPermissions();
        $this->permissionsViaRoles = $current->getPermissionsViaRoles()->pluck('name')->toArray();
        $this->permissions = [
            [
                'label'=>'Onboarding - Access',
                'key'=>'onboarding-access'
            ],
            [
                'label'=>'Super Admin Dashboard - Access',
                'key'=>'dashboard-super-admin-access'
            ],
            [
                'label'=>'Admin Dashboard - Access',
                'key'=>'dashboard-admin-access'
            ],
            [
                'label'=>'TWG Dashboard - Access',
                'key'=>'dashboard-twg-access'
            ],
            [
                'label'=>'FP/O Dashboard - Access',
                'key'=>'dashboard-fp-o-access'
            ],
            [
                'label'=>'Bulletin - Access',
                'key'=>'bulletin-access',
                'subs'=>[
                    [
                        'label'=>'Manage Posts - Access',
                        'key'=>'bulletin-manage-posts-access'
                    ],
                    [
                        'label'=>'Boards - Access',
                        'key'=>'bulletin-boards-access'
                    ],
                ]
            ],
           
            [
                'label'=>'Mail - Access',
                'key'=>'mail-access'
            ],
            [
                'label'=>'Users - Access',
                'key'=>'users-access',
                'subs'=>[
                    [
                        'label'=>'Approval & Suspension - Access',
                        'key'=>'users-approval-suspension-access'
                    ],
                    [
                        'label'=>'Super Administrator - Access',
                        'key'=>'users-super-administrator-access'
                    ],
                    [
                        'label'=>'Administrator - Access',
                        'key'=>'users-administrator-access'
                    ],
                    [
                        'label'=>'Technical Working Group - Access',
                        'key'=>'users-technical-working-froup-access'
                    ],
                    [
                        'label'=>'Planning Focal - Access',
                        'key'=>'users-planning-focal-access'
                    ],
                ]
            ],
            
            [
                'label'=>'Field Dependency - Access',
                'key'=>'field-dependency-access',
                'subs'=>[
                    [
                        'label'=>'Division/Section - Access',
                        'key'=>'division-section-access'
                    ],
                    [
                        'label'=>'Position - Access',
                        'key'=>'position-access'
                    ],
                    [
                        'label'=>'Service/Region - Access',
                        'key'=>'service-region-access'
                    ],
                    [
                        'label'=>'Target Sectors - Access',
                        'key'=>'target-sectors-access'
                    ],
                    [
                        'label'=>'Procurement Mode - Access',
                        'key'=>'procurement-mode-access'
                    ],
                    [
                        'label'=>'Allotment Class - Access',
                        'key'=>'allotment-class-access'
                    ],
                    [
                        'label'=>'Fund Chargeability - Access',
                        'key'=>'fund-chargeability-access'
                    ],
                    [
                        'label'=>'Chart of Accounts - Access',
                        'key'=>'chart-of-accounts-access'
                    ],
                    [
                        'label'=>'Categorized Accounts - Access',
                        'key'=>'categorized-accounts-access'
                    ],
                    [
                        'label'=>'PAP Tagging - Access',
                        'key'=>'pap-tagging-access'
                    ],
                    [
                        'label'=>'Default PAPs - Access',
                        'key'=>'default-paps-access'
                    ],
                    [
                        'label'=>'Default sub-PAPs - Access',
                        'key'=>'default-sub-paps-access'
                    ],
                    [
                        'label'=>'Default Item Requirement - Access',
                        'key'=>'default-item-requirement-access'
                    ],
                ]
            ],
           
            [
                'label'=>'Forms - Access',
                'key'=>'forms-access',
                'subs'=>[
                    [
                        'label'=>'Working Fiscal Limits - Access',
                        'key'=>'form-working-fiscal-limits-access'
                    ],
                    [
                        'label'=>'POE Form - Access',
                        'key'=>'form-poe-access'
                    ],
                    [
                        'label'=>'PPMP Form - Access',
                        'key'=>'form-ppmp-access'
                    ],
                    [
                        'label'=>'PPMP Classification - Access',
                        'key'=>'form-ppmp-classification-access'
                    ],
                    [
                        'label'=>'PPMP Classification - Budget Access',
                        'key'=>'form-ppmp-classification-all-access'
                    ],
                    [
                        'label'=>'Budget Form-Funded - Access',
                        'key'=>'form-budget-funded-access'
                    ],
                    [
                        'label'=>'Budget Form-Unfunded - Access',
                        'key'=>'form-budget-unfunded-access'
                    ],
                    [
                        'label'=>'APB FORM - Access',
                        'key'=>'form-apb-access'
                    ],
                    [
                        'label'=>'OPC FORM - Access',
                        'key'=>'form-opc-access'
                    ],
                ]
            ],
           
            [
                'label'=>'Reports - Access',
                'key'=>'reports-access',
                'subs'=>[
                    [
                        'label'=>'Working Fiscal Limit Report - Access',
                        'key'=>'report-working-fiscal-limit-access'
                    ],
                    [
                        'label'=>'POE Report - Access',
                        'key'=>'report-poe-access'
                    ],
                    [
                        'label'=>'PPMP Report - Access',
                        'key'=>'report-ppmp-access'
                    ],
                    [
                        'label'=>'Budget Report - Access',
                        'key'=>'report-budget-access'
                    ],
                    [
                        'label'=>'APB Report - Access',
                        'key'=>'report-apb-access'
                    ],
                    [
                        'label'=>'OPC Report - Access',
                        'key'=>'report-opc-access'
                    ],
                ]
            ],
            
            [
                'label'=>'Audit Trail - Access',
                'key'=>'audit-trail-access'
            ],
            [
                'label'=>'Data Guard - Access',
                'key'=>'data-guard-access',
                'subs'=>[
                    [
                        'label'=>'Roles and Permissions - Access',
                        'key'=>'roles-and-permissions-access'
                    ],
                    [
                        'label'=>'Special Privileges - Access',
                        'key'=>'special-privileges-access'
                    ],
                ]
            ],
           
            [
                'label'=>'Account Settings - Access',
                'key'=>'account-settings-access',
            ]
        ];
    }
}
