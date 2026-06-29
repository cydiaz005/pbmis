<div style="padding-top: 25px">
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="addNewComment"> 
                            <h4>Comments</h4>
                            @if (session()->has('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <input type="text" class="form-control" wire:model="newComment">
                                @error('newComment')
                                    <small id="helpId" class="text-danger">{{@$message}}</small>
                                @enderror
                            </div>
                            
                          

                            <div class="form-group" style="align-item:right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <div class="col-8 offset-2">
                @foreach($comments as $comment)
                    <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote">
                        <p>{{$comment['body']}}</p>
                        <footer class="card-blockquote">
                            {{$comment['creator']['name'] }} &nbsp; 
                            <cite title="Source title">{{$comment['created_at']}}</cite>
                        </footer>
                        </blockquote>
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
