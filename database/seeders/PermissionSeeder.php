<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // access => pertains to links
        // create => can store
        // edit => can update
        // show => displays collection
        // delete => delete tuple

        $permissions = [
            'general',
            'onboarding-access',
            'dashboard-super-admin-access',
            'dashboard-admin-access',
            'dashboard-plans-access',
            'dashboard-budget-access',
            'dashboard-procurement-access',
            'dashboard-twg-access',
            'dashboard-fp-o-access',
            'bulletin-access',
            'bulletin-manage-posts-access',
            'bulletin-boards-access',
            'mail-access',
            'users-access',
            'users-approval-suspension-access',
            'users-super-administrator-access',
            'users-administrator-access',
            'users-technical-working-froup-access',
            'users-planning-focal-access',
            'field-dependency-access',
            'division-section-access',
            'position-access',
            'service-region-access',
            'target-sectors-access',
            'procurement-mode-access',
            'allotment-class-access',
            'fund-chargeability-access',
            'chart-of-accounts-access',
            'categorized-accounts-access',
            'pap-tagging-access',
            'default-paps-access',
            'default-sub-paps-access',
            'default-item-requirement-access',
            'priority-class-access',
            'mfo-access',
            'kdpkdks-access',
            'forms-access',
            'form-working-fiscal-limits-access',
            'form-poe-access',
            'form-ppmp-access',
            'form-ppmp-classification-access',
            'form-budget-funded-access',
            'form-budget-unfunded-access',
            'form-apb-access',
            'form-opc-access',
            'reports-access',
            'report-working-fiscal-limit-access',
            'report-poe-access',
            'report-ppmp-access',
            'report-budget-access',
            'report-apb-access',
            'report-opc-access',
            'audit-trail-access',
            'data-guard-access',
            'roles-and-permissions-access',
            'special-privileges-access',
            'account-settings-access',
            'stages-access',
            'form-ppmp-classification-all-access',
            'horizon-access'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $this->assignPermissionToRole();
    }

    public function assignPermissionToRole()
    {

        $superAdministrator = Role::findById(1);
        $administrator = Role::findById(2);
        $technicalWorkingGroup = Role::findById(3);
        $planningFocalOfficer = Role::findById(4);
        $guest = Role::findById(5);
        $developer = Role::findById(6);
        $plansAdministrator = Role::findById(7);
        $budgetAdministrator = Role::findById(8);
        $procAdministrator = Role::findById(9);
        $encoder = Role::findById(10);





        
        $developer->givePermissionTo('general');
        $developer->givePermissionTo('onboarding-access');
        $developer->givePermissionTo('dashboard-super-admin-access');
        $developer->givePermissionTo('dashboard-plans-access');
        $developer->givePermissionTo('dashboard-budget-access');
        $developer->givePermissionTo('dashboard-procurement-access');
        $developer->givePermissionTo('dashboard-admin-access');
        $developer->givePermissionTo('dashboard-twg-access');
        $developer->givePermissionTo('dashboard-fp-o-access');
        $developer->givePermissionTo('bulletin-access');
        $developer->givePermissionTo('bulletin-manage-posts-access');
        $developer->givePermissionTo('bulletin-boards-access');
        $developer->givePermissionTo('mail-access');
        $developer->givePermissionTo('users-access');
        $developer->givePermissionTo('users-approval-suspension-access');
        $developer->givePermissionTo('users-super-administrator-access');
        $developer->givePermissionTo('users-administrator-access');
        $developer->givePermissionTo('users-technical-working-froup-access');
        $developer->givePermissionTo('users-planning-focal-access');
        $developer->givePermissionTo('field-dependency-access');
        $developer->givePermissionTo('division-section-access');
        $developer->givePermissionTo('position-access');
        $developer->givePermissionTo('service-region-access');
        $developer->givePermissionTo('target-sectors-access');
        $developer->givePermissionTo('procurement-mode-access');
        $developer->givePermissionTo('allotment-class-access');
        $developer->givePermissionTo('fund-chargeability-access');
        $developer->givePermissionTo('chart-of-accounts-access');
        $developer->givePermissionTo('categorized-accounts-access');
        $developer->givePermissionTo('pap-tagging-access');
        $developer->givePermissionTo('default-paps-access');
        $developer->givePermissionTo('default-sub-paps-access');
        $developer->givePermissionTo('default-item-requirement-access');
        $developer->givePermissionTo('priority-class-access');
        $developer->givePermissionTo('mfo-access');
        $developer->givePermissionTo('kdpkdks-access');
        $developer->givePermissionTo('forms-access');
        $developer->givePermissionTo('form-working-fiscal-limits-access');
        $developer->givePermissionTo('form-poe-access');
        $developer->givePermissionTo('form-ppmp-access');
        $developer->givePermissionTo('form-ppmp-classification-access');
        $developer->givePermissionTo('form-budget-funded-access');
        $developer->givePermissionTo('form-budget-unfunded-access');
        $developer->givePermissionTo('form-apb-access');
        $developer->givePermissionTo('form-opc-access');
        $developer->givePermissionTo('reports-access');
        $developer->givePermissionTo('report-working-fiscal-limit-access');
        $developer->givePermissionTo('report-poe-access');
        $developer->givePermissionTo('report-ppmp-access');
        $developer->givePermissionTo('report-budget-access');
        $developer->givePermissionTo('report-apb-access');
        $developer->givePermissionTo('report-opc-access');
        $developer->givePermissionTo('audit-trail-access');
        $developer->givePermissionTo('data-guard-access');
        $developer->givePermissionTo('roles-and-permissions-access');
        $developer->givePermissionTo('special-privileges-access');
        $developer->givePermissionTo('account-settings-access');
        $developer->givePermissionTo('stages-access');
        $developer->givePermissionTo('horizon-access');

        $superAdministrator->givePermissionTo('general');
        // $superAdministrator->givePermissionTo('onboarding-access');
        $superAdministrator->givePermissionTo('dashboard-super-admin-access');
        $superAdministrator->givePermissionTo('bulletin-access');
        $superAdministrator->givePermissionTo('bulletin-manage-posts-access');
        $superAdministrator->givePermissionTo('bulletin-boards-access');
        $superAdministrator->givePermissionTo('mail-access');
        $superAdministrator->givePermissionTo('users-access');
        $superAdministrator->givePermissionTo('users-approval-suspension-access');
        $superAdministrator->givePermissionTo('users-super-administrator-access');
        $superAdministrator->givePermissionTo('users-administrator-access');
        $superAdministrator->givePermissionTo('users-technical-working-froup-access');
        $superAdministrator->givePermissionTo('users-planning-focal-access');
        $superAdministrator->givePermissionTo('field-dependency-access');
        $superAdministrator->givePermissionTo('division-section-access');
        $superAdministrator->givePermissionTo('position-access');
        $superAdministrator->givePermissionTo('service-region-access');
        // $superAdministrator->givePermissionTo('target-sectors-access');
        // $superAdministrator->givePermissionTo('procurement-mode-access');
        // $superAdministrator->givePermissionTo('allotment-class-access');
        // $superAdministrator->givePermissionTo('fund-chargeability-access');
        // $superAdministrator->givePermissionTo('chart-of-accounts-access');
        // $superAdministrator->givePermissionTo('categorized-accounts-access');
        // $superAdministrator->givePermissionTo('pap-tagging-access');
        // $superAdministrator->givePermissionTo('default-paps-access');
        // $superAdministrator->givePermissionTo('default-sub-paps-access');
        // $superAdministrator->givePermissionTo('default-item-requirement-access');
        // $superAdministrator->givePermissionTo('priority-class-access');
        // $superAdministrator->givePermissionTo('mfo-access');
        // $superAdministrator->givePermissionTo('kdpkdks-access');
        $superAdministrator->givePermissionTo('reports-access');
        $superAdministrator->givePermissionTo('report-working-fiscal-limit-access');
        $superAdministrator->givePermissionTo('report-poe-access');
        $superAdministrator->givePermissionTo('report-ppmp-access');
        $superAdministrator->givePermissionTo('report-budget-access');
        $superAdministrator->givePermissionTo('report-apb-access');
        $superAdministrator->givePermissionTo('report-opc-access');
        $superAdministrator->givePermissionTo('audit-trail-access');
        $superAdministrator->givePermissionTo('data-guard-access');
        $superAdministrator->givePermissionTo('roles-and-permissions-access');
        $superAdministrator->givePermissionTo('special-privileges-access');
        $superAdministrator->givePermissionTo('account-settings-access');
        $superAdministrator->givePermissionTo('stages-access');


        $administrator->givePermissionTo('general');
        $administrator->givePermissionTo('dashboard-admin-access');
        $administrator->givePermissionTo('bulletin-access');
        $administrator->givePermissionTo('bulletin-manage-posts-access');
        $administrator->givePermissionTo('bulletin-boards-access');
        $administrator->givePermissionTo('mail-access');
        // $administrator->givePermissionTo('users-access');
        $administrator->givePermissionTo('users-approval-suspension-access');
        $administrator->givePermissionTo('users-technical-working-froup-access');
        $administrator->givePermissionTo('users-planning-focal-access');
        // fd
        $administrator->givePermissionTo('field-dependency-access');
        // $administrator->givePermissionTo('division-section-access');
        // $administrator->givePermissionTo('position-access');
        // $administrator->givePermissionTo('service-region-access');
        $administrator->givePermissionTo('target-sectors-access');
        $administrator->givePermissionTo('procurement-mode-access');
        $administrator->givePermissionTo('allotment-class-access');
        $administrator->givePermissionTo('fund-chargeability-access');
        $administrator->givePermissionTo('chart-of-accounts-access');
        $administrator->givePermissionTo('categorized-accounts-access');
        $administrator->givePermissionTo('pap-tagging-access');
        $administrator->givePermissionTo('default-paps-access');
        $administrator->givePermissionTo('default-sub-paps-access');
        $administrator->givePermissionTo('default-item-requirement-access');
        $administrator->givePermissionTo('priority-class-access');
        $administrator->givePermissionTo('mfo-access');
        $administrator->givePermissionTo('kdpkdks-access');
        // forms
        $administrator->givePermissionTo('forms-access');
        $administrator->givePermissionTo('form-working-fiscal-limits-access');
        $administrator->givePermissionTo('form-poe-access');
        $administrator->givePermissionTo('form-ppmp-access');
        $administrator->givePermissionTo('form-ppmp-classification-access');
        $administrator->givePermissionTo('form-budget-funded-access');
        $administrator->givePermissionTo('form-budget-unfunded-access');
        // $administrator->givePermissionTo('form-apb-access');
        $administrator->givePermissionTo('form-opc-access');
        $administrator->givePermissionTo('reports-access');
        $administrator->givePermissionTo('report-working-fiscal-limit-access');
        $administrator->givePermissionTo('report-poe-access');
        $administrator->givePermissionTo('report-ppmp-access');
        $administrator->givePermissionTo('report-budget-access');
        $administrator->givePermissionTo('report-apb-access');
        $administrator->givePermissionTo('report-opc-access');
        $administrator->givePermissionTo('audit-trail-access');
        $administrator->givePermissionTo('account-settings-access');


        // plans
        $plansAdministrator->givePermissionTo('general');
        $plansAdministrator->givePermissionTo('dashboard-plans-access');
        $plansAdministrator->givePermissionTo('bulletin-access');
        $plansAdministrator->givePermissionTo('bulletin-manage-posts-access');
        $plansAdministrator->givePermissionTo('bulletin-boards-access');
        $plansAdministrator->givePermissionTo('mail-access');
        // $plansAdministrator->givePermissionTo('users-access');
        $plansAdministrator->givePermissionTo('users-administrator-access');
        $plansAdministrator->givePermissionTo('users-approval-suspension-access');
        $plansAdministrator->givePermissionTo('users-technical-working-froup-access');
        $plansAdministrator->givePermissionTo('users-planning-focal-access');
        // fd
        $plansAdministrator->givePermissionTo('field-dependency-access');
        // $plansAdministrator->givePermissionTo('division-section-access');
        // $plansAdministrator->givePermissionTo('position-access');
        // $plansAdministrator->givePermissionTo('service-region-access');
        $plansAdministrator->givePermissionTo('target-sectors-access');
        $plansAdministrator->givePermissionTo('procurement-mode-access');
        $plansAdministrator->givePermissionTo('allotment-class-access');
        $plansAdministrator->givePermissionTo('fund-chargeability-access');
        $plansAdministrator->givePermissionTo('chart-of-accounts-access');
        $plansAdministrator->givePermissionTo('categorized-accounts-access');
        $plansAdministrator->givePermissionTo('pap-tagging-access');
        $plansAdministrator->givePermissionTo('default-paps-access');
        $plansAdministrator->givePermissionTo('default-sub-paps-access');
        $plansAdministrator->givePermissionTo('default-item-requirement-access');
        $plansAdministrator->givePermissionTo('priority-class-access');
        $plansAdministrator->givePermissionTo('mfo-access');
        $plansAdministrator->givePermissionTo('kdpkdks-access');
        // forms
        $plansAdministrator->givePermissionTo('forms-access');
        // $plansAdministrator->givePermissionTo('form-working-fiscal-limits-access');
        $plansAdministrator->givePermissionTo('form-poe-access');
        $plansAdministrator->givePermissionTo('form-ppmp-access');
        $plansAdministrator->givePermissionTo('form-ppmp-classification-access');
        $plansAdministrator->givePermissionTo('form-budget-funded-access');
        $plansAdministrator->givePermissionTo('form-budget-unfunded-access');
        // $plansAdministrator->givePermissionTo('form-apb-access');
        $plansAdministrator->givePermissionTo('form-opc-access');
        $plansAdministrator->givePermissionTo('reports-access');
        $plansAdministrator->givePermissionTo('report-working-fiscal-limit-access');
        $plansAdministrator->givePermissionTo('report-poe-access');
        $plansAdministrator->givePermissionTo('report-ppmp-access');
        $plansAdministrator->givePermissionTo('report-budget-access');
        $plansAdministrator->givePermissionTo('report-apb-access');
        $plansAdministrator->givePermissionTo('report-opc-access');
        $plansAdministrator->givePermissionTo('audit-trail-access');
        $plansAdministrator->givePermissionTo('account-settings-access');

        // budget
        $budgetAdministrator->givePermissionTo('general');
        $budgetAdministrator->givePermissionTo('dashboard-budget-access');
        $budgetAdministrator->givePermissionTo('bulletin-access');
        $budgetAdministrator->givePermissionTo('bulletin-manage-posts-access');
        $budgetAdministrator->givePermissionTo('bulletin-boards-access');
        $budgetAdministrator->givePermissionTo('mail-access');
        // $budgetAdministrator->givePermissionTo('users-access');
        $budgetAdministrator->givePermissionTo('users-administrator-access');
        $budgetAdministrator->givePermissionTo('users-approval-suspension-access');
        $budgetAdministrator->givePermissionTo('users-technical-working-froup-access');
        $budgetAdministrator->givePermissionTo('users-planning-focal-access');
        // fd
        $budgetAdministrator->givePermissionTo('field-dependency-access');
        // $budgetAdministrator->givePermissionTo('division-section-access');
        // $budgetAdministrator->givePermissionTo('position-access');
        // $budgetAdministrator->givePermissionTo('service-region-access');
        $budgetAdministrator->givePermissionTo('target-sectors-access');
        $budgetAdministrator->givePermissionTo('procurement-mode-access');
        $budgetAdministrator->givePermissionTo('allotment-class-access');
        $budgetAdministrator->givePermissionTo('fund-chargeability-access');
        $budgetAdministrator->givePermissionTo('chart-of-accounts-access');
        $budgetAdministrator->givePermissionTo('categorized-accounts-access');
        $budgetAdministrator->givePermissionTo('pap-tagging-access');
        $budgetAdministrator->givePermissionTo('default-paps-access');
        $budgetAdministrator->givePermissionTo('default-sub-paps-access');
        $budgetAdministrator->givePermissionTo('default-item-requirement-access');
        $budgetAdministrator->givePermissionTo('priority-class-access');
        $budgetAdministrator->givePermissionTo('mfo-access');
        $budgetAdministrator->givePermissionTo('kdpkdks-access');
        // forms
        $budgetAdministrator->givePermissionTo('forms-access');
        $budgetAdministrator->givePermissionTo('form-working-fiscal-limits-access');
        // $budgetAdministrator->givePermissionTo('form-poe-access');
        // $budgetAdministrator->givePermissionTo('form-ppmp-access');
        $budgetAdministrator->givePermissionTo('form-ppmp-classification-access');
        $budgetAdministrator->givePermissionTo('form-budget-funded-access');
        $budgetAdministrator->givePermissionTo('form-budget-unfunded-access');
        // $budgetAdministrator->givePermissionTo('form-apb-access');
        $budgetAdministrator->givePermissionTo('form-opc-access');
        $budgetAdministrator->givePermissionTo('reports-access');
        $budgetAdministrator->givePermissionTo('report-working-fiscal-limit-access');
        $budgetAdministrator->givePermissionTo('report-poe-access');
        $budgetAdministrator->givePermissionTo('report-ppmp-access');
        $budgetAdministrator->givePermissionTo('report-budget-access');
        $budgetAdministrator->givePermissionTo('report-apb-access');
        $budgetAdministrator->givePermissionTo('report-opc-access');
        $budgetAdministrator->givePermissionTo('audit-trail-access');
        $budgetAdministrator->givePermissionTo('account-settings-access');

        // procurement
        $procAdministrator->givePermissionTo('general');
        $procAdministrator->givePermissionTo('dashboard-procurement-access');
        $procAdministrator->givePermissionTo('bulletin-access');
        $procAdministrator->givePermissionTo('bulletin-manage-posts-access');
        $procAdministrator->givePermissionTo('bulletin-boards-access');
        $procAdministrator->givePermissionTo('mail-access');
        // $procAdministrator->givePermissionTo('users-access');
        $procAdministrator->givePermissionTo('users-administrator-access');
        $procAdministrator->givePermissionTo('users-approval-suspension-access');
        $procAdministrator->givePermissionTo('users-technical-working-froup-access');
        $procAdministrator->givePermissionTo('users-planning-focal-access');
        // fd
        $procAdministrator->givePermissionTo('field-dependency-access');
        // $procAdministrator->givePermissionTo('division-section-access');
        // $procAdministrator->givePermissionTo('position-access');
        // $procAdministrator->givePermissionTo('service-region-access');
        $procAdministrator->givePermissionTo('target-sectors-access');
        $procAdministrator->givePermissionTo('procurement-mode-access');
        $procAdministrator->givePermissionTo('allotment-class-access');
        $procAdministrator->givePermissionTo('fund-chargeability-access');
        $procAdministrator->givePermissionTo('chart-of-accounts-access');
        $procAdministrator->givePermissionTo('categorized-accounts-access');
        $procAdministrator->givePermissionTo('pap-tagging-access');
        $procAdministrator->givePermissionTo('default-paps-access');
        $procAdministrator->givePermissionTo('default-sub-paps-access');
        $procAdministrator->givePermissionTo('default-item-requirement-access');
        $procAdministrator->givePermissionTo('priority-class-access');
        $procAdministrator->givePermissionTo('mfo-access');
        $procAdministrator->givePermissionTo('kdpkdks-access');
        // forms
        $procAdministrator->givePermissionTo('forms-access');
        $procAdministrator->givePermissionTo('form-working-fiscal-limits-access');
        $procAdministrator->givePermissionTo('form-poe-access');
        $procAdministrator->givePermissionTo('form-ppmp-access');
        $procAdministrator->givePermissionTo('form-ppmp-classification-access');
        $procAdministrator->givePermissionTo('form-budget-funded-access');
        $procAdministrator->givePermissionTo('form-budget-unfunded-access');
        // $procAdministrator->givePermissionTo('form-apb-access');
        $procAdministrator->givePermissionTo('form-opc-access');
        $procAdministrator->givePermissionTo('reports-access');
        $procAdministrator->givePermissionTo('report-working-fiscal-limit-access');
        $procAdministrator->givePermissionTo('report-poe-access');
        $procAdministrator->givePermissionTo('report-ppmp-access');
        $procAdministrator->givePermissionTo('report-budget-access');
        $procAdministrator->givePermissionTo('report-apb-access');
        $procAdministrator->givePermissionTo('report-opc-access');
        $procAdministrator->givePermissionTo('audit-trail-access');
        $procAdministrator->givePermissionTo('account-settings-access');


        $technicalWorkingGroup->givePermissionTo('general');
        $technicalWorkingGroup->givePermissionTo('dashboard-twg-access');
        $technicalWorkingGroup->givePermissionTo('bulletin-access');
        $technicalWorkingGroup->givePermissionTo('bulletin-manage-posts-access');
        $technicalWorkingGroup->givePermissionTo('bulletin-boards-access');
        $technicalWorkingGroup->givePermissionTo('mail-access');
        // $technicalWorkingGroup->givePermissionTo('users-access');
        $technicalWorkingGroup->givePermissionTo('users-planning-focal-access');
        // Forms
        $technicalWorkingGroup->givePermissionTo('forms-access');
        $technicalWorkingGroup->givePermissionTo('form-poe-access');
        $technicalWorkingGroup->givePermissionTo('form-ppmp-access');
        $technicalWorkingGroup->givePermissionTo('form-ppmp-classification-access');
        $technicalWorkingGroup->givePermissionTo('form-opc-access');
        // FD
        $technicalWorkingGroup->givePermissionTo('field-dependency-access');
        $technicalWorkingGroup->givePermissionTo('target-sectors-access');
        // $technicalWorkingGroup->givePermissionTo('procurement-mode-access');
        // $technicalWorkingGroup->givePermissionTo('allotment-class-access');
        // $technicalWorkingGroup->givePermissionTo('fund-chargeability-access');
        // $technicalWorkingGroup->givePermissionTo('chart-of-accounts-access');
        // $technicalWorkingGroup->givePermissionTo('categorized-accounts-access');
        $technicalWorkingGroup->givePermissionTo('pap-tagging-access');
        $technicalWorkingGroup->givePermissionTo('default-paps-access');
        $technicalWorkingGroup->givePermissionTo('default-sub-paps-access');
        // $technicalWorkingGroup->givePermissionTo('default-item-requirement-access');
        // $technicalWorkingGroup->givePermissionTo('priority-class-access');
        // $technicalWorkingGroup->givePermissionTo('mfo-access');
        // $technicalWorkingGroup->givePermissionTo('kdpkdks-access');

        // Reports
        $technicalWorkingGroup->givePermissionTo('reports-access');
        $technicalWorkingGroup->givePermissionTo('report-working-fiscal-limit-access');
        $technicalWorkingGroup->givePermissionTo('report-poe-access');
        $technicalWorkingGroup->givePermissionTo('report-ppmp-access');
        $technicalWorkingGroup->givePermissionTo('report-budget-access');
        $technicalWorkingGroup->givePermissionTo('report-apb-access');
        $technicalWorkingGroup->givePermissionTo('report-opc-access');
        // $technicalWorkingGroup->givePermissionTo('audit-trail-access');
        $technicalWorkingGroup->givePermissionTo('account-settings-access');

        $planningFocalOfficer->givePermissionTo('general');
        $planningFocalOfficer->givePermissionTo('dashboard-fp-o-access');
        $planningFocalOfficer->givePermissionTo('bulletin-access');
        $planningFocalOfficer->givePermissionTo('bulletin-boards-access');
        $planningFocalOfficer->givePermissionTo('mail-access');
        $planningFocalOfficer->givePermissionTo('forms-access');
        $planningFocalOfficer->givePermissionTo('form-poe-access');
        $planningFocalOfficer->givePermissionTo('form-opc-access');
        $planningFocalOfficer->givePermissionTo('reports-access');
        $planningFocalOfficer->givePermissionTo('report-working-fiscal-limit-access');
        $planningFocalOfficer->givePermissionTo('report-poe-access');
        $planningFocalOfficer->givePermissionTo('report-ppmp-access');
        $planningFocalOfficer->givePermissionTo('report-budget-access');
        $planningFocalOfficer->givePermissionTo('report-apb-access');
        $planningFocalOfficer->givePermissionTo('report-opc-access');
        $planningFocalOfficer->givePermissionTo('account-settings-access');


        $encoder->givePermissionTo('general');
        $encoder->givePermissionTo('dashboard-fp-o-access');
        $encoder->givePermissionTo('bulletin-access');
        $encoder->givePermissionTo('bulletin-boards-access');
        $encoder->givePermissionTo('mail-access');
        $encoder->givePermissionTo('forms-access');
        $encoder->givePermissionTo('form-poe-access');
        $encoder->givePermissionTo('form-opc-access');
        $encoder->givePermissionTo('reports-access');
        $encoder->givePermissionTo('report-working-fiscal-limit-access');
        $encoder->givePermissionTo('report-poe-access');
        $encoder->givePermissionTo('report-ppmp-access');
        $encoder->givePermissionTo('report-budget-access');
        $encoder->givePermissionTo('report-apb-access');
        $encoder->givePermissionTo('report-opc-access');
        $encoder->givePermissionTo('account-settings-access');

        $guest->givePermissionTo('general');
        $guest->givePermissionTo('onboarding-access');
        // $guest->givePermissionTo('account-settings-access');

        // $superAdministrator->givePermissionTo('dashboardAdmin_access');
        // $regionalAdministrator->givePermissionTo('dashboardRegional_access');
        // $regionalUser->givePermissionTo('dashboardUser_access');
        // $guest->givePermissionTo('onboarding_access');
    }
}
