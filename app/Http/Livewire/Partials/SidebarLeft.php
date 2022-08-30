<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class SidebarLeft extends Component
{
    public $applictionName;
    public $applictionLogo;
    public $username;
    public $role;
    public $profileImage;
    public $menus;



    public function render()
    {
        $default = env('APP_NAME', 'Telmo Solutions CMS');
        $this->applictionName = $default;
        $this->applictionLogo = $this->uiAvatar($default);
        return view('livewire.partials.sidebar-left');
    }
    public function mount()
    {
        $this->user = auth()->user();
        $this->username =  $this->user->firstname.' '.$this->user->lastname;
        $this->role =  $this->user->getRoleNames();

        if(isset($this->user->profilePhoto)){

            $this->profileImage =  asset('public/images/'.$this->user->profilePhoto->url);
        }
        else{
            $this->profileImage =  $this->uiAvatar($this->user->firstname);
            
        }
        $this->constructSideBarMenu();
        // dd($this->user);
    }

    public function uiAvatar($str)
    {
        return "https://ui-avatars.com/api/?name=".$str."&background=0D8ABC&color=fff";
    }

    public function constructSideBarMenu()
    {
        $this->menus = [
            [
                'li_id' => 'li_onboarding',
                'icon' => 'nav-icon fas fa-th-list',
                'label' => 'Onboarding',
                'route' => '/onboarding1',
                'permission' => 'onboarding-access',
            ],
            [
                'li_id' => 'li_superdashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'Super Admin Dashboard',
                'route' => '/dashboard/super-administrator',
                'permission' => 'dashboard-super-admin-access',
            ],
            [
                'li_id' => 'li_admindashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'Admin Dashboard',
                'route' => '/dashboard/administrator',
                'permission' => 'dashboard-admin-access',
            ],
            [
                'li_id' => 'li_plansdashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'Plans Dashboard',
                'route' => '/dashboard/plans',
                'permission' => 'dashboard-plans-access',
            ],
            [
                'li_id' => 'li_budgetdashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'Budget Dashboard',
                'route' => '/dashboard/budget',
                'permission' => 'dashboard-budget-access',
            ],
            [
                'li_id' => 'li_procurementdashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'Procurement Dashboard',
                'route' => '/dashboard/procurement',
                'permission' => 'dashboard-procurement-access',
            ],
            [
                'li_id' => 'li_twgdashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'TWG Dashboard',
                'route' => '/dashboard/techinical-working-group',
                'permission' => 'dashboard-twg-access',
            ],
            [
                'li_id' => 'li_fpodashboard',
                'icon' => 'nav-icon fas fa-tachometer-alt',
                'label' => 'FP/O Dashboard',
                'route' => '/dashboard/planning-focal-officer',
                'permission' => 'dashboard-fp-o-access',
            ],
            [
                'li_id' => 'li_bulletin',
                'icon' => 'nav-icon fas fa-bullhorn',
                'label' => 'Bulletin',
                'route' => '#',
                'permission' => 'bulletin-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_manageposts',
                        'icon' => 'nav-icon far fa-edit',
                        'label' => 'Manage Posts',
                        'route' => '/bulletin/manage',
                        'permission' => 'bulletin-manage-posts-access',
                    ],
                    [
                        'li_id' => 'li_boards',
                        'icon' => 'nav-icon fas fa-clipboard-list',
                        'label' => 'Boards',
                        'route' => '/bulletin/board',
                        'permission' => 'bulletin-boards-access',
                    ],
                ]
            ],
            [
                'li_id' => 'li_mail',
                'icon' => 'nav-icon fa fa-envelope',
                'label' => 'Mail',
                'route' => '/mail/inbox',
                'permission' => 'mail-access',
            ],
            [
                'li_id' => 'li_users',
                'icon' => 'nav-icon fas fa-users',
                'label' => 'Users',
                'route' => '#',
                'permission' => 'users-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_approval',
                        'icon' => 'nav-icon far fa-user',
                        'label' => 'Super Administrator',
                        'route' => '/user/all',
                        'permission' => 'users-approval-suspension-access',
                    ],
                    // [
                    //     'li_id' => 'li_superadmin',
                    //     'icon' => 'nav-icon far fa-user',
                    //     'label' => 'Super Administrator',
                    //     'route' => '/user/super-administrator',
                    //     'permission' => 'users-super-administrator-access',
                    // ],
                    [
                        'li_id' => 'li_admin',
                        'icon' => 'nav-icon far fa-user',
                        'label' => 'Administrator',
                        'route' => '/user/administrator',
                        'permission' => 'users-administrator-access',
                    ],
                    [
                        'li_id' => 'li_twg',
                        'icon' => 'nav-icon far fa-user',
                        'label' => 'Technical Working Group',
                        'route' => '/user/techinical-working-group',
                        'permission' => 'users-technical-working-froup-access',
                    ],
                    [
                        'li_id' => 'li_unveried',
                        'icon' => 'nav-icon far fa-user',
                        'label' => 'Unverified',
                        'route' => '/user/unverified',
                        'permission' => 'general',
                    ],
                ]
            ],
            [
                'li_id' => 'li_forms',
                'icon' => 'nav-icon fas fa-archive',
                'label' => 'Forms',
                'route' => '#',
                'permission' => 'forms-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_fiscal',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Working Fiscal Limits',
                        'route' => '/form/working-fiscal-limit',
                        'permission' => 'form-working-fiscal-limits-access',
                    ],
                    [
                        'li_id' => 'li_poeform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'POE Form',
                        'route' => '/form/poe',
                        'permission' => 'form-poe-access',
                    ],
                    [
                        'li_id' => 'li_ppmpform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'PPMP Form',
                        'route' => '/form/ppmp',
                        'permission' => 'form-ppmp-access',
                    ],
                    [
                        'li_id' => 'li_ppmpclassify',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'PPMP Classification',
                        'route' => '/form/ppmp/classify',
                        'permission' => 'form-ppmp-classification-access',
                    ],
                    [
                        'li_id' => 'li_fundedform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Budget Form (Funded)',
                        'route' => '/form/budget-funded',
                        'permission' => 'form-budget-funded-access',
                    ],
                    [
                        'li_id' => 'li_unfundedform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Budget Form (Unfunded)',
                        'route' => '/form/budget-unfunded',
                        'permission' => 'form-budget-unfunded-access',
                    ],
                    [
                        'li_id' => 'li_appform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'APP FORM',
                        'route' => '/form/app-form',
                        'permission' => 'general',
                    ],
                    [
                        'li_id' => 'li_opcform',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'OPC FORM',
                        'route' => '/form/opc',
                        'permission' => 'form-opc-access',
                    ],
                ]
            ],
            [
                'li_id' => 'li_reports',
                'icon' => 'nav-icon fas fa-newspaper',
                'label' => 'Reports',
                'route' => '#',
                'permission' => 'reports-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_fiscalreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Working Fiscal Limit Report',
                        'route' => '/reports/fiscal-limit',
                        'permission' => 'report-working-fiscal-limit-access',
                    ],
                    [
                        'li_id' => 'li_poereport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'POE Report',
                        'route' => '/reports/poe',
                        'permission' => 'report-poe-access',
                    ],
                    [
                        'li_id' => 'li_ppmpreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'PPMP Report',
                        'route' => '/reports/ppmp',
                        'permission' => 'report-ppmp-access',
                    ],
                    [
                        'li_id' => 'li_budgetreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Budget Report - Funded',
                        'route' => '/reports/budget/funded',
                        'permission' => 'report-budget-access',
                    ],
                    [
                        'li_id' => 'li_budgetreport2',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'Budget Report - Unfunded',
                        'route' => '/reports/budget/unfunded',
                        'permission' => 'report-budget-access',
                    ],
 
                    [
                        'li_id' => 'li_apbreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'APB Report',
                        'route' => '/pages/reports/apb',
                        'permission' => 'report-apb-access',
                    ],
                    [
                        'li_id' => 'li_appreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'APP Report',
                        'route' => '/reports/app-form',
                        'permission' => 'general',
                    ],
                    [
                        'li_id' => 'li_opcreport',
                        'icon' => 'fas fa-file-alt nav-icon',
                        'label' => 'OPC Report',
                        'route' => '/pages/reports/opc',
                        'permission' => 'report-opc-access',
                    ],
                ]
            ],
            [
                'li_id' => 'li_field',
                'icon' => 'nav-icon fas fa-magic',
                'label' => 'Field Dependency',
                'route' => '#',
                'permission' => 'field-dependency-access',
                'sub-menus' => [
                    [
                        'nav-header' => "PROFILE"
                    ],
                    [
                        'li_id' => 'li_division',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Division/Section',
                        'route' => '/field-dependency/profile/division-section',
                        'permission' => 'division-section-access',
                    ],
                    [
                        'li_id' => 'li_position',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Position',
                        'route' => '/field-dependency/profile/position',
                        'permission' => 'position-access',
                    ],
                    [
                        'li_id' => 'li_service',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Service/Region',
                        'route' => '/field-dependency/profile/service-region',
                        'permission' => 'service-region-access',
                    ],
                    [
                        'nav-header' => "DATA ENTRY"
                    ],
                    [
                        'li_id' => 'li_target',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Target Sectors',
                        'route' => '/field-dependency/data-entry/target-sector',
                        'permission' => 'target-sectors-access',
                    ],
                    [
                        'li_id' => 'li_procurement',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Procurement Mode',
                        'route' => '/field-dependency/data-entry/procurement-mode',
                        'permission' => 'procurement-mode-access',
                    ],
                    [
                        'li_id' => 'li_allotment',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Allotment Class',
                        'route' => '/field-dependency/data-entry/allotment-class',
                        'permission' => 'allotment-class-access',
                    ],
                    [
                        'li_id' => 'li_fundchargeability',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Fund Chargeability',
                        'route' => '/field-dependency/data-entry/fund-chargeability',
                        'permission' => 'fund-chargeability-access',
                    ],
                    [
                        'li_id' => 'li_chartaccount',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Chart of Accounts',
                        'route' => '/field-dependency/data-entry/chart-of-accounts',
                        'permission' => 'chart-of-accounts-access',
                    ],
                    [
                        'li_id' => 'li_categorized',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Categorized Accounts',
                        'route' => '/field-dependency/data-entry/categorized-account',
                        'permission' => 'categorized-accounts-access',
                    ],
                    [
                        'li_id' => 'li_paptagging',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'PAP Tagging',
                        'route' => '/field-dependency/data-entry/pap-tagging',
                        'permission' => 'pap-tagging-access',
                    ],
                    [
                        'li_id' => 'li_priority_class',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Priority Class',
                        'route' => '/field-dependency/data-entry/priority-class',
                        'permission' => 'priority-class-access',
                    ],
                    [
                        'li_id' => 'li_mfo',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Major Final Output',
                        'route' => '/field-dependency/data-entry/mfo',
                        'permission' => 'mfo-access',
                    ],
                    [
                        'li_id' => 'li_kdpkpks',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Key Document Product/Key Product/ Key Service',
                        'route' => '/field-dependency/data-entry/kdpkdks',
                        'permission' => 'kdpkdks-access',
                    ],
                    [
                        'li_id' => 'li_defaultpap',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Default PAPs',
                        'route' => '/field-dependency/data-entry/default-pap',
                        'permission' => 'default-paps-access',
                    ],
                    [
                        'li_id' => 'li_defaultsub',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Default Sub-PAPs',
                        'route' => '/field-dependency/data-entry/default-sub-pap',
                        'permission' => 'default-sub-paps-access',
                    ],
                    [
                        'li_id' => 'li_defaultitem',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Default Item Requirement',
                        'route' => '/field-dependency/data-entry/default-itemRequirement',
                        'permission' => 'default-item-requirement-access',
                    ],
                    [
                        'li_id' => 'li_stages',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Stages',
                        'route' => '/field-dependency/data-entry/stages',
                        'permission' => 'default-item-requirement-access',
                    ],
                    [
                        'li_id' => 'li_performance_measures',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Performance Measures',
                        'route' => '/field-dependency/data-entry/performance-measures',
                        'permission' => 'report-opc-access',//TODO PERMISSION
                    ],
                    [
                        'li_id' => 'li_office_per_mfo',
                        'icon' => 'nav-icon far fa-circle',
                        'label' => 'Office per MFO',
                        'route' => '/field-dependency/data-entry/office-mfo',
                        'permission' => 'report-opc-access',//TODO PERMISSION
                    ],
                ]
            ],
            [
                'li_id' => 'li_audit',
                'icon' => 'nav-icon fa fa-history',
                'label' => 'Audit Trail',
                'route' => '/audit-trail',
                'permission' => 'audit-trail-access',
            ],

            [
                'li_id' => 'li_dataguard',
                'icon' => 'nav-icon fas fa-shield-alt',
                'label' => 'Data Guard',
                'route' => '#',
                'permission' => 'data-guard-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_roles',
                        'icon' => 'far fa-user nav-icon',
                        'label' => 'Roles and Permissions',
                        'route' => '/data-guard/roles-permissions',
                        'permission' => 'roles-and-permissions-access',
                    ],
                    [
                        'li_id' => 'li_privileges',
                        'icon' => 'far fa-user nav-icon',
                        'label' => 'Special Privileges',
                        'route' => '/data-guard/special-privileges',
                        'permission' => 'special-privileges-access',
                    ],
                ]
            ],
            [
                'li_id' => 'li_resource',
                'icon' => 'fas fa-link nav-icon',
                'label' => 'Resource',
                'route' => '#',
                'permission' => 'reports-access',
                'sub-menus' => [
                    [
                        'li_id' => 'li_resource_accounts',
                        'icon' => 'nav-icon far fa-user',
                        'label' => 'Resource Account',
                        'route' => '/resource/resource-accounts',
                        'permission' => 'general',
                    ],
                    [
                        'li_id' => 'li_resource_doc',
                        'icon' => 'nav-icon fas fa-newspaper ',
                        'label' => 'Resource Document',
                        'route' => '/resource/resource-docs',
                        'permission' => 'general',
                    ],
                    [
                        'li_id' => 'li_resource_vid',
                        'icon' => 'nav-icon fas fa-video',
                        'label' => 'Resource Videos',
                        'route' => '/resource/resource-videos',
                        'permission' => 'general',
                    ],
                ]
            ],
            [
                'li_id' => 'li_stage',
                'icon' => 'nav-icon fa fa-exclamation-triangle',
                'label' => 'Form Stage',
                'route' => '/manage/stage',
                'permission' => 'stages-access',
                
            ],
            [
                'li_id' => 'li_account',
                'icon' => 'nav-icon fa fa-cogs',
                'label' => 'Account Settings',
                'route' => '/settings',
                'permission' => 'account-settings-access',
            ],
           
            
        ];

    }
}
