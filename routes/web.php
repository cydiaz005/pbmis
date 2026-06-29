<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FieldDependencyController;
use App\Http\Controllers\DataGuardController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PoeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FiscalLimitController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrashmailController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\OpcController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ApbController;
use App\Http\Controllers\AppFormController;
use App\Http\Controllers\ResourceAccountController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test', function () {
    $s = Auth::user();
    // return $s->rol->role->name;
    return view('email_template.general_mailer');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/', [DashboardController::class, 'redirect']);
    Route::get('landing', [DashboardController::class, 'redirect']);
    Route::prefix('dashboard')->group(function () {
        Route::get('super-administrator', [DashboardController::class, 'superAdmin']);
        Route::get('administrator', [DashboardController::class, 'admin']);
        Route::get('techinical-working-group', [DashboardController::class, 'twg']);
        Route::get('planning-focal-officer', [DashboardController::class, 'pfo']);
        Route::get('plans', [DashboardController::class, 'plans']);
        Route::get('budget', [DashboardController::class, 'budget']);
        Route::get('procurement', [DashboardController::class, 'procurement']);
        Route::post('procurement/get-data', [DashboardController::class, 'getProcurementData']);
        Route::get('procurement/list', [DashboardController::class, 'procurementDataList']);
        Route::get('plans-widget-keys', [DashboardController::class, 'plansWidgetKeys']);
        Route::prefix('plans-list-of-paps')->group(function () {
            Route::get('office', [DashboardController::class, 'plansListOfPapsPerOffice']);
            Route::get('priority-class', [DashboardController::class, 'plansListOfPapsPerpriorityClass']);
            Route::get('kdpkpks', [DashboardController::class, 'plansListOfPapsPerkdpkpks']);
            Route::get('paptag', [DashboardController::class, 'plansListOfPapsPerpaptag']);
            Route::get('target-sector', [DashboardController::class, 'plansListOfPapsPertargetSector']);
            Route::get('thematic-areas-clusters', [DashboardController::class, 'plansListOfPapsPerthematicAreaClusters']);
        });
    });
    Route::prefix('bulletin')->group(function () {
        Route::get("manage", [AnnouncementController::class, "view"]);
        Route::post("manage", [AnnouncementController::class, "create"]);
        Route::post("announcement.edit", [AnnouncementController::class, "update"]);
        Route::post("announcement.destroy", [AnnouncementController::class, "destroy"]);
        Route::get("board", [AnnouncementController::class, "board"]);
        Route::get("roles/{announcement_id}", [AnnouncementController::class, "getRolesAnnouncement"]);
        Route::post("board", [AnnouncementController::class, "boardPaginate"]);
    });
    Route::prefix('user')->group(function () {
        Route::post('create', [UserController::class, 'storeAndBoard']);
        Route::put('/{id}/change-profile-photo', [UserController::class, 'changeProfilePhoto']);
        Route::get('all', [UserController::class, 'all']);
        Route::get('super-administrator', [UserController::class, 'superAdmin']);
        Route::get('administrator', [UserController::class, 'admin']);
        Route::get('unverified', [UserController::class, 'unverifiedUser']);
        Route::get('techinical-working-group', [UserController::class, 'twg']);
        Route::get('planning-focal-office', [UserController::class, 'pfo']);
        Route::put('/{id}/change-role', [UserController::class, 'changeRole']);
        Route::put('/{id}/change-status', [UserController::class, 'changeStatus']);
        Route::put('/{id}/change-service', [UserController::class, 'changeServiceUser']);
    });
    Route::group(['prefix' => 'mail', 'middleware' => 'mail_access'], function () {
        Route::get('/compose', [MailController::class, 'mailCompose']);
        Route::get('/compose/draft/{id}', [MailController::class, 'draftToCompose']);
        Route::get('/inbox', [MailController::class, 'mailInbox']);
        Route::get('/sent', [MailController::class, 'mailSent']);
        Route::get('/draft', [MailController::class, 'mailDraft']);
        Route::get('/trash', [MailController::class, 'mailTrash']);
        Route::prefix('read')->group(function () {
            Route::get('/sent/{id}', [MailController::class, 'readSentMail']);
            Route::get('/inbox/{id}', [MailController::class, 'readInboxMail']);
            Route::get('/trash/{id}', [MailController::class, 'readSentTrash']);
            Route::get('/draft/{id}', [MailController::class, 'readSentDraft']);
        });
        Route::prefix('get')->group(function () {
            Route::post('/inbox', [MailController::class, 'getInboxMails']);
            Route::post('/sent', [MailController::class, 'getSentMails']);
            Route::post('/replies/{id}', [MailController::class, 'getReplies']);
            Route::post("/draft", [MailController::class, 'getDraftMail']);
        });
        Route::group(['prefix' => 'file'], function () {
            Route::post('/pre-upload', [MailController::class, 'preUploadFiles']);
            Route::delete('/remove', [MailController::class, 'removeFiles']);
        });
        Route::get('/files/{filepath}', [MailController::class, 'previewFile']);
        Route::post('/search-emails', [MailController::class, 'searchMail']);
        Route::post('/save-mail', [MailController::class, 'saveMail']);
        Route::post('/save-reply', [MailController::class, 'saveReply']);
        Route::post("/delete-draft", [MailController::class, "deleteMail"]);
        Route::post("/delete-trash", [MailController::class, "deleteMail"]);
        Route::post("/search-email", [MailController::class, "searchBySearch"]);
        Route::post("/trash-sent-data", [TrashmailController::class, "deleteToTrashSentBox"]);
        Route::post("/trash-datas", [TrashmailController::class, "viewTrash"]);
        Route::post("/update-sent/{sentbox_id}/{mailId}", [MailController::class, "updateToSent"]);
        Route::post("/delete-trash-data", [MailController::class, "deleteTrashData"]);
        Route::post("/delete-mail-file/{id}", [MailController::class, "deleteMailFile"]);
        Route::post("/recount-mail", [MailController::class, "recount"]);
        Route::post("/recover-trashdata", [MailController::class, "recoverTrash"]);
    });
    Route::prefix('form')->group(function () {
        Route::prefix('working-fiscal-limit')->group(function () {
            Route::get('/', [FiscalLimitController::class, 'index']);
            Route::get('create', [FiscalLimitController::class, 'create'])->name('fiscal-limit.create');
            Route::get('modify', [FiscalLimitController::class, 'create'])->name('fiscal-limit.modify');
            Route::post('save', [FiscalLimitController::class, 'save']);
            Route::post('edit', [FiscalLimitController::class, 'edit']);
            Route::post('fetch', [FiscalLimitController::class, 'getFiscalLimit']);
            Route::post('delete', [FiscalLimitController::class, 'delete']);
        });
        Route::prefix('poe')->group(function () {
            Route::get('/', [PoeController::class, 'formPoe']);
            Route::get('edit/{id}', [PoeController::class, 'editPoe'])->name('edit-poe');
            Route::post('get/subpaps', [PoeController::class, 'getSubpaps']);
            Route::get('get/{status}', [PoeController::class, 'getPoe']);
            Route::post('fetch', [PoeController::class, 'getPoe']);
            Route::post('fetch/by-group', [PoeController::class, 'fetchByGroup']);
            Route::get('create/{parameter}', [PoeController::class, 'formPoeCreate']);
            Route::post('poe-create', [PoeController::class, 'encryptUrlParams']);
            Route::get('get/kdp/{id}', [PoeController::class, 'getKdp']);
            Route::post('search/account-code', [PoeController::class, 'searchAcountCode']);
            Route::post('search/item-requirement', [PoeController::class, 'searchItemRequirement']);
            Route::post('search/subpap', [PoeController::class, 'searchSubpap']);
            Route::post('search/pap', [PoeController::class, 'searchPap']);
            Route::post('search/unit', [PoeController::class, 'searchUnit']);
            Route::post('save', [PoeController::class, 'save']);
            Route::post('update', [PoeController::class, 'update']);
            Route::post('publish', [PoeController::class, 'publish']);
            Route::post('return', [PoeController::class, 'return']);
            Route::post('delete', [PoeController::class, 'delete']);
            Route::post('resolve', [PoeController::class, 'resolve']);
            Route::post('lock-unlock', [PoeController::class, 'lockUnlock']);
            Route::get('view/{id}', [PoeController::class, 'viewPoe']);
            Route::get('test', [PoeController::class, 'test']);
        });
        Route::prefix('ppmp')->group(function () {
            Route::get('/', [PoeController::class, 'formPpmp']);
            Route::get('classify', [PoeController::class, 'classify']);
            Route::get('view/{id}', [PoeController::class, 'viewPpmp'])->name('view-ppmp');
            Route::post('get/funded-forms', [PoeController::class, 'getFundedPpmps']);
            Route::post('get/unfunded-forms', [PoeController::class, 'getUnfundedPpmps']);
            // Route::get('get/{status}', [PoeController::class, 'getPpmp']);
            Route::post('get/unclassified-forms', [PoeController::class, 'getUnclassifiedPpmps']);
            Route::post('fetch', [PoeController::class, 'getPpmp']);
            Route::post('publish', [PoeController::class, 'publishPpmp']);
            Route::post('save-classifications', [PoeController::class, 'savePpmpClassifications']);
            Route::post('return', [PoeController::class, 'returnPpmp']);
            Route::post('delete', [PoeController::class, 'deletePpmp']);
            Route::post('approve-classification', [PoeController::class, 'approveClassification']);
            Route::post('lock-unlock', [PoeController::class, 'lockUnlockPpmp']);
            Route::post('resolve', [PoeController::class, 'resolvePpmp']);
        });
        Route::prefix('app-form')->group(function () {
            Route::get('/', [AppFormController::class, 'show']);
            Route::get('create/{year}', [AppFormController::class, 'create']);
            Route::get('edit/{id}', [AppFormController::class, 'edit']);
            Route::get('view/{id}', [AppFormController::class, 'view']);
            Route::post('delete', [AppFormController::class, 'delete']);
            Route::post('fetch', [AppFormController::class, 'fetch']);
            Route::post('save', [AppFormController::class, 'save']);
            Route::post('list', [AppFormController::class, 'list']);
            Route::post('pre-creation-data', [AppFormController::class, 'encryptUrlParams']);
        });
        Route::prefix('opc')->group(function () {
            Route::get('{id}', [OpcController::class, 'fetchOneOpc']);
            Route::get('edit/{id}', [OpcController::class, 'editOpc'])->name('edit-opc');
            Route::put('unlock/{id}', [OpcController::class, 'unlockOpc']);
            Route::post('lock-unlock', [OpcController::class, 'lockUnlock']);
            Route::put('publish/{id}', [OpcController::class, 'publishOpc']);
            Route::put('change-status/{id}', [OpcController::class, 'changeStatus']);
            Route::put('update/{id}', [OpcController::class, 'updateOpc']);
            Route::delete('delete/{id}', [OpcController::class, 'deleteOpc']);
            Route::get('create/{params}', [OpcController::class, 'create']);
            Route::post('init-create', [OpcController::class, 'initCreate']);
            Route::post('fetch', [OpcController::class, 'fetchGroupedPpmp']);
            Route::post('store/{params}', [OpcController::class, 'storeForm']);
            Route::post('fetch-data', [OpcController::class, 'getOpc']);
            Route::post('return', [OpcController::class, 'return']);
        });
    });
    Route::prefix("resource")->group(function () {
        Route::get("resource-accounts", [ResourceAccountController::class, 'viewResourceAccount']);
        Route::put("resource-account", [ResourceAccountController::class, 'createResourceAccount']);
        Route::post("resource-account", [ResourceAccountController::class, 'updateResourceAccount']);
        Route::delete("resource-account", [ResourceAccountController::class, 'deleteResourceAccount']);
        Route::get("resource-docs", [ResourceAccountController::class, 'viewDocument']);
        Route::get("resource-videos", [ResourceAccountController::class, 'viewVideos']);
        Route::put("resource-doc", [ResourceAccountController::class, 'createResource']);
        Route::post("resource-doc", [ResourceAccountController::class, 'updateResource']);
        Route::delete("resource-doc", [ResourceAccountController::class, 'deleteResource']);
        Route::post("resource-account/search", [ResourceAccountController::class, 'searchResourceAccount']);
    });
    Route::prefix('reports')->group(function () {
        Route::prefix('fiscal-limit')->group(function () {
            Route::get('/', [FiscalLimitController::class, 'fiscalLimitReport']);
            Route::get('get/{stage}/{year}', [FiscalLimitController::class, 'getReport']);
            Route::post('fetch', [FiscalLimitController::class, 'fetch']);
        });
        Route::prefix('poe')->group(function () {
            Route::get('/', [PoeController::class, 'poeReport']);
            Route::get('get', [PoeController::class, 'getReport']);
        });
        Route::prefix('ppmp')->group(function () {
            Route::get('/', [PoeController::class, 'ppmpReport']);
            Route::get('get', [PoeController::class, 'getReport']);
        });
        Route::prefix('budget/funded')->group(function () {
            Route::get('/', [PoeController::class, 'budgetFundedReport']);
            Route::post('fetch', [PoeController::class, 'getBudgetFundedReport']);
            Route::post('data', [PoeController::class, 'getBudgetReportData']);
            Route::get('get/{stage}/{year}/{region}', [PoeController::class, 'viewFundedReport']);
        });
        Route::prefix('budget/unfunded')->group(function () {
            Route::get('/', [PoeController::class, 'budgetUnfundedReport']);
            Route::post('fetch', [PoeController::class, 'getBudgetUnFundedReport']);
            Route::post('data', [PoeController::class, 'getBudgetReportData']);
            Route::get('get/{stage}/{year}/{region}', [PoeController::class, 'viewUnfundedReport']);
        });
        Route::prefix('apb')->group(function () {
            Route::get('/', [PoeController::class, 'apbReport']);
            Route::post('fetch', [PoeController::class, 'getAPBReport']);
            Route::post('data', [PoeController::class, 'getAPBdata']);
            Route::get('get/{stage}/{year}/{region}', [PoeController::class, 'viewApbReport']);
        });
        Route::prefix('app-form')->group(function () {
            Route::get('/', [AppFormController::class, 'showReport']);
        });
        Route::prefix('opc')->group(function () {
            Route::get('/', [ReportController::class, '']);
            Route::post('fetch', [PoeController::class, 'getOPCReport']);
            Route::get('get', [ReportController::class, 'getReport']);
            Route::post('data', [OpcController::class, 'getData']);
            Route::get('{id}', [OpcController::class, 'fetchOneOpc']);
        });
        Route::post('/table/apb', [ApbController::class, 'table']);
        Route::post('/table/budget-funded', [BudgetController::class, 'budget_funded']);
        Route::post('/table/budget-unfunded', [BudgetController::class, 'budget_unfunded']);
        Route::post('/table/fiscal-limit', [BudgetController::class, 'fiscal_limit']);
        Route::post('/table/opc', [OpcController::class, 'opc_table']);

        Route::get('/view/ppmp/{id}', [PoeController::class, 'viewPpmpReport'])->name('view-ppmp-report');
        Route::get('/view/poe/{id}', [PoeController::class, 'viewPoeReport'])->name('view-ppmp-report');
    });
    Route::prefix('field-dependency')->group(function () {
        Route::prefix('profile')->group(function () {
            Route::get('division-section', [FieldDependencyController::class, 'divisionSection']);
            Route::get('position', [FieldDependencyController::class, 'position']);
            Route::get('service-region', [FieldDependencyController::class, 'serviceRegion']);


            // STORE ROUTES
            Route::post('division-section', [FieldDependencyController::class, 'storeDivisionSection']);
            Route::post('position', [FieldDependencyController::class, 'storePosition']);
            Route::post('service-region', [FieldDependencyController::class, 'storeServiceRegion']);

            //DELETE ROUTES
            Route::delete('division-section/{id}', [FieldDependencyController::class, 'deleteDivisionSection']);
            Route::delete('position/{id}', [FieldDependencyController::class, 'deletePosition']);
            Route::delete('service-region/{id}', [FieldDependencyController::class, 'deleteServiceRegion']);
        });
        Route::prefix('data-entry')->group(function () {
            Route::get('target-sector', [FieldDependencyController::class, 'targetSector']);
            Route::get('procurement-mode', [FieldDependencyController::class, 'procurementMode']);
            Route::get('allotment-class', [FieldDependencyController::class, 'allotmentClass']);
            Route::get('fund-chargeability', [FieldDependencyController::class, 'fundChargeability']);
            Route::get('chart-of-accounts', [FieldDependencyController::class, 'chartOfAccounts']);
            Route::get('categorized-account', [FieldDependencyController::class, 'categorizedAccount']);
            Route::get('means-of-verification', [FieldDependencyController::class, 'meansOfVerification']);
            Route::get('pap-tagging', [FieldDependencyController::class, 'papTags']);
            Route::get('default-pap', [FieldDependencyController::class, 'suggestedPap']);
            Route::get('default-sub-pap', [FieldDependencyController::class, 'suggestedSubPap']);
            Route::get('default-itemRequirement', [FieldDependencyController::class, 'itemRequirement']);
            Route::get('priority-class', [FieldDependencyController::class, 'priorityClass']);
            Route::get('mfo', [FieldDependencyController::class, 'mfo']);
            Route::get('kdpkdks', [FieldDependencyController::class, 'kdpkdks']);
            Route::get('stages', [FieldDependencyController::class, 'stages']);
            Route::get('performance-measures', [FieldDependencyController::class, 'performanceMeasures']);
            Route::get('office-mfo', [FieldDependencyController::class, 'officePerMfo']);
            Route::get('office-mfo/{id}', [FieldDependencyController::class, 'editOfficePerMfo']);

            //STORE ROUTES
            Route::post('fund-chargeability', [FieldDependencyController::class, 'storeFundChargeability']);
            Route::post('priority-class', [FieldDependencyController::class, 'storePriorityClass']);
            Route::post('target-sector', [FieldDependencyController::class, 'storeTargetSector']);
            Route::post('procurement-mode', [FieldDependencyController::class, 'storeProcurementMode']);
            Route::post('allotment-class', [FieldDependencyController::class, 'storeAllotmentClass']);
            Route::post('chart-of-accounts', [FieldDependencyController::class, 'storeChartOfAccounts']);

            Route::post('categorized-account', [FieldDependencyController::class, 'storeCategorizedAccount']);
            Route::post('categorized-fcc-coa', [FieldDependencyController::class, 'storeCoaFccCategory']);
            Route::post('categorized-kdpkpks-mfo', [FieldDependencyController::class, 'storeKdpkpksMfoCategory']);
            Route::post('pap-tagging', [FieldDependencyController::class, 'storePapTags']);
            Route::post('default-pap', [FieldDependencyController::class, 'storeSuggestedPap']);
            Route::post('default-sub-pap', [FieldDependencyController::class, 'storeSuggestedSubPap']);
            Route::post('default-itemRequirement', [FieldDependencyController::class, 'storeItemRequirement']);
            Route::post('mfo', [FieldDependencyController::class, 'storeMfo']);
            Route::post('mov', [FieldDependencyController::class, 'storeMov']);
            Route::post('kdpkdks', [FieldDependencyController::class, 'storeKdpkdks']);
            Route::post('stages', [FieldDependencyController::class, 'storeStage']);
            Route::post('performance-measures', [FieldDependencyController::class, 'storePerformanceMeasures']);

            //DELETE ROUTES
            Route::delete('fund-chargeability/{id}', [FieldDependencyController::class, 'deleteFundChargeability']);
            Route::delete('priority-class/{id}', [FieldDependencyController::class, 'deletePriorityClass']);
            Route::delete('target-sector/{id}', [FieldDependencyController::class, 'deleteTargetSector']);
            Route::delete('procurement-mode/{id}', [FieldDependencyController::class, 'deleteProcurementMode']);
            Route::delete('allotment-class/{id}', [FieldDependencyController::class, 'deleteAllotmentClass']);
            Route::delete('chart-of-accounts/{id}', [FieldDependencyController::class, 'deleteChartOfAccounts']);


            Route::delete('categorized-account/{id}', [FieldDependencyController::class, 'deleteCategorizedAccount']);
            Route::delete('categorized-fcc-coa/{id}', [FieldDependencyController::class, 'deleteCoaFccCategory']);
            Route::delete('categorized-kdpkpks-mfo/{id}', [FieldDependencyController::class, 'deleteKdpkpksMfoCategory']);
            Route::delete('pap-tagging/{id}', [FieldDependencyController::class, 'deletePapTags']);
            Route::delete('default-pap/{id}', [FieldDependencyController::class, 'deleteSuggestedPap']);
            Route::delete('default-sub-pap/{id}', [FieldDependencyController::class, 'deleteSuggestedSubPap']);
            Route::delete('default-itemRequirement/{id}', [FieldDependencyController::class, 'deleteItemRequirement']);
            Route::delete('mfo/{id}', [FieldDependencyController::class, 'deleteMfo']);
            Route::delete('mov/{id}', [FieldDependencyController::class, 'deleteMov']);
            Route::delete('kdpkdks/{id}', [FieldDependencyController::class, 'deleteKdpkdks']);
            Route::delete('stages/{id}', [FieldDependencyController::class, 'deleteStage']);
            Route::delete('performance-measures/{id}', [FieldDependencyController::class, 'deletePerformanceMeasures']);

            //UPDATE ROUTES
            Route::put('mfo/{id}/change-order', [FieldDependencyController::class, 'changeMfoOrder']);
            Route::put('stages/{id}/change-status', [FieldDependencyController::class, 'changeStageStatus']);
            Route::put('office-mfo/{id}', [FieldDependencyController::class, 'updateOfficeMfos']);
        });
    });
    Route::prefix('audit-trail')->group(function () {
        Route::get('/', [AuditTrailController::class, 'index']);
    });
    Route::prefix('data-guard')->group(function () {
        Route::get('roles-permissions', [DataGuardController::class, 'rolesPermissions']);
        Route::post('roles-permissions/roles', [RoleController::class, 'store']);
        Route::delete('roles-permissions/roles/{id}', [RoleController::class, 'destroy']);
        Route::put('roles-permissions/{role_id}', [PermissionController::class, 'update']);
        Route::put('special-privileges/user/{id}', [PermissionController::class, 'updateUserPermission']);
        Route::get('special-privileges', [DataGuardController::class, 'specialPriveleges']);
        Route::get('special-privileges/{id}', [DataGuardController::class, 'editSpecialPrivileges'])->name('special-privileges.edit');
    });
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::post('/update', [SettingController::class, 'updateSetting']);
    });
    Route::get('form/template', [PageController::class, 'formTemplate']);
    Route::get('form/opc', [PageController::class, 'formOpc']);
    Route::get('form/apb1a', [PageController::class, 'formApb1a']);
    Route::get('form/budget-funded', [PageController::class, 'formBudgetFunded']);
    Route::get('form/budget-unfunded', [PageController::class, 'formBudgetUnfunded']);
    // Route::get('form/ppmp', [PageController::class, 'formPpmp']);
    Route::get('/pages/reports/apb', function () {
        return view('pages/reports/apb');
    });
    Route::get('/pages/reports/opc', function () {
        return view('pages/reports/opc');
    });
    Route::group(['prefix' => 'analytics/budget'], function () {
        Route::get('/allotment-class', [AnalyticController::class, 'budgetAllotmentClass']);
        Route::get('/fund-chargeabilty', [AnalyticController::class, 'budgetFundChargeabilty']);
        Route::get('/category', [AnalyticController::class, 'budgetCategory']);
        Route::get('/per-service-region', [AnalyticController::class, 'budgetServiceRegion']);
    });
    Route::group(['prefix' => 'notification', 'middleware' => 'auth'], function () {
        Route::post('get', [NotificationController::class, 'getNotifications']);
        Route::post('seen', [NotificationController::class, 'seenNotification']);
        Route::delete("", [NotificationController::class, "removeAllNotification"]);
    });
    Route::group(['prefix' => 'manage/stage', 'middleware' => 'auth'], function () {
        Route::get('/', [SettingController::class, 'stage']);
        Route::post('set', [SettingController::class, 'setActiveStage']);
    });
});

Route::get('/modify-stage', function () {
    return view('pages.stage-warning');
});

Route::get('/onboarding1', function () {
    return view('onboarding1');
});


Route::get('/onboarding2', function () {
    abort(404);
    return view('onboarding2');
});
Route::get('/onboarding3', [OnboardingController::class, 'onboarding3']);
Route::put('onboard3/{id}', [OnboardingController::class, 'update']);
Route::get('/onboarding4', function () {
    abort(404);
    return view('onboarding4');
});
Route::get('/onboarding5', function () {
    return view('onboarding5');
});

Route::get('report/{type}/{id}', function ($type, $id) {
    return (Auth::user()->hasPermissionTo('report_access')) ?  view('pages.report')->with(['type' => $type])->with(['id' => $id]) : abort(403);
});
Route::get("user/verify/email/pre-registration/{token}", [UserController::class, 'verifiedUser']);

Route::get("/test-due", [PoeController::class, 'PPMPDUE']);
Route::get("/test/{id}", [PoeController::class, 'test1']);
