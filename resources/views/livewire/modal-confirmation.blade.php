<!-- comfirm edit -->
<div class="modal fade" id="confirmEdit" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Confirmation</h3>
                <p class="cnfrmodal_text">Are you sure you want to edit this file?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button id="confirmEditButton" type="button" class="btn btn-primary btn-pos">Yes, continue</button>
            </div>
        </div>
    </div>
</div>

<!-- comfirm delete -->
<div class="modal fade" id="confirmDelete" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                    <h3 class="cnfrmodal_title">Permanently Delete</h3>
                    <p class="cnfrmodal_text">Are you sure you want to permanently delete this file? After a file is
                        permanently deleted, it <strong style="color: #343a40">cannot be recovered.</strong>
                    </p><br>
                    <div class="form-group">
                        <label style="font-weight: 400;" class="form-label">Please type "<strong id="match-string-display">delete</strong>" to confirm</label>
                        <input type="text" class="form-control form-input" id="match-string" placeholder="Enter">
                    </div>
                </div>
                <div class="modal-footer justify-content-end" style="border-top: 0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                    <button  id="confirmDeleteButton" type="button" class="btn btn-primary btn-pos">Yes, delete file</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- comfirm lock -->
<div class="modal fade" id="confirmLock" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Lock File</h3>
                <p class="cnfrmodal_text">Are you sure you want to lock this file? If a file is locked for editing, it
                    <strong style="color: #343a40">cannot be edited or modified by anyone</strong> unless you unlock the file first.</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button  type="button" class="btn btn-primary">Yes, lock file</button>
            </div>
        </div>
    </div>
</div>

<!-- comfirm unlock -->
<div class="modal fade" id="confirmUnlock" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Unlock File</h3>
                <p class="cnfrmodal_text">Unlocking a file means anyone who has an access on this file
                    can edit. Are you sure you want to continue?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button id="confirmUnlockButton" type="button" class="btn btn-primary btn-pos">Yes, continue</button>
            </div>
        </div>
    </div>
</div>

<!-- comfirm publish -->
<div class="modal fade" id="confirmPublish" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Publish File</h3>
                <p class="cnfrmodal_text">Are you sure you want to publish this file?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button id="confirmPublishButton" type="button" class="btn btn-primary btn-pos">Yes, continue</button>
            </div>
        </div>
    </div>
</div>


<!-- comfirm submit -->
<div class="modal fade" id="confirmSubmit" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Submit File</h3>
                <p class="cnfrmodal_text">Are you sure you want to submit this file?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button id="confirmSubmitButton" type="button" class="btn btn-primary btn-pos">Yes, continue</button>
            </div>
        </div>
    </div>
</div>

<!-- comfirm return -->
{{-- <div class="modal fade" id="confirmReturn" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Return File</h3>
                <p class="cnfrmodal_text">Are you sure you want to return this file?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button id="confirmReturnButton" type="button" class="btn btn-primary btn-pos">Yes, continue</button>
            </div>
        </div>
    </div>
</div> --}}

<!-- comfirm approve -->
<div class="modal fade" id="confirmApprove" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                <h3 class="cnfrmodal_title">Approve Form</h3>
                <p class="cnfrmodal_text">Are you sure you want to approve this form?</p>
            </div>
            <div class="modal-footer justify-content-end" style="border-top: 0;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                <button type="button" class="btn btn-primary">Yes, continue</button>
            </div>
        </div>
    </div>
</div>

<!-- comfirm return -->
<div class="modal fade" id="confirmReturn" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0;border: 0;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-right: 0px;margin-top: 0px;">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form>
                <div class="modal-body" style="padding: 30px;padding-bottom: 10px;">
                    <h3 class="cnfrmodal_title">Return Form</h3>
                    <p class="cnfrmodal_text">You are about to return
                        <strong style="color: #343a40" id="modal-return-pap-title">PAP Title form,</strong> please state your reason below.
                    </p><br>
                    <div class="form-group">
                        <div class="d-flex justify-content-end">
                            <small><span id="modal-return-reason-length">0</span>/200</small>
                        </div>
                        <textarea class="form-control form-input" rows="3" placeholder="Write here ..." id="modal-return-pap-reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-end" style="border-top: 0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>&nbsp;
                    <button type="button" class="btn btn-primary" id="modal-return-pap-btn">Return Form</button>
                </div>
            </form>
        </div>
    </div>
</div>

