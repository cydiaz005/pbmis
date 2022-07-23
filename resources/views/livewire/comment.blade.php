<div style="padding-top: 25px">
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        <form wire:submit.prevent="addNewComment"> 
                            <h4>Comments</h4>
                            <div class="form-group">
                                <input type="text" class="form-control" wire:model.lazy="newComment">
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
                      <footer class="card-blockquote">{{$comment['creator'] }}&nbsp; <cite title="Source title">{{$comment['created_at']}}</cite></footer>
                    </blockquote>
                  </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
