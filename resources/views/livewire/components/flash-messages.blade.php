<div class="message" id="{{$parent_id}}">
    @if (session()->has("success-" . $parent_id))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session("success-". $parent_id) }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @elseif (session()->has("error-" . $parent_id))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session("error-" . $parent_id) }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
</div>