<div class="modal fade" id="createPAPmodal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/form/poe/poe-create" method="POST" id="">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel">Create POE</h5> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="input-label" for="pap-year">Year</label><br>
                    <select name="year" id="pap-year" class="form-control form-input" required>
                        @for($i = 2022; $i <= \Carbon\Carbon::now()->format('Y') + 6; $i++)
                              <option {{$i == \Carbon\Carbon::now()->format('Y') + 1 ? "selected":""}} value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label class="input-label" for="papname">PAP</label>
                    <input type="text" name="papname" id="papname" class="form-control form-input" required>
                </div>
                
                <div class="form-group">
                    <label class="input-label" for="target_sector">MFO</label><br>
                    <select name="mfo" class="select2 form-control" for="target_sector" id="mfo" required>
                        <option value="">Select MFO</option>
                        @foreach ($mfo as $mfo)
                            <option value="{{$mfo->mfo_id}}">{{$mfo->mfo->priorityClass->accronym}}-{{$mfo->mfo->desc}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="display: none" id="kdp-container">
                    <label class="input-label" for="target_sector">KDP/KP/KS</label><br>
                    <select name="kdp" class="select2 form-control" for="target_sector" id="kdp" required>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
        </form>
    </div>
</div>