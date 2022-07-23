<div class="col-md-3">
    <div class="card">
    <div class="card-header p-0">
        <a href="/mail/compose" class="btn btn-primary btn-block">Compose</a>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
        <li class="nav-item active">
            <a href="/mail/inbox" class="nav-link">
            <i class="fas fa-inbox"></i> Inbox
            <span class="badge bg-primary float-right" id="inbox-badge">{{(\App\Models\UserInbox::where([['user_id', Auth::user()->id], ['seen', '1'], ['status', "0"]])->count()) ?: ''}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/mail/sent" class="nav-link">
            <i class="far fa-envelope"></i> Sent
            <span class="badge bg-primary float-right" id="sent-badge">{{(\App\Models\UserSentbox::where([['user_id', Auth::user()->id], ['seen', '1'],  ['status', "0"]])->count()) ?: ''}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/mail/draft" class="nav-link">
            <i class="far fa-file-alt"></i> Drafts
            <span class="badge bg-primary float-right" id="draft-badge">{{(\App\Models\UserSentbox::where([['user_id', Auth::user()->id],['seen', '1'],  ['status', "1"]])->count()) ?: ''}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="/mail/trash" class="nav-link">
            <i class="far fa-trash-alt"></i> Trash
            <span class="badge bg-primary float-right">{{(\App\Models\Trashmail::where([['user_id', Auth::user()->id],['seen', '1']])->count()) ?: ''}}</span>
            </a>
        </li>
        </ul>
    </div>
    <!-- /.card-body -->
    </div>
</div>