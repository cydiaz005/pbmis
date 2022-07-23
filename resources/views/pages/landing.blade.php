@extends('layouts.theme')

@section('content')
   

    <div class="card">
           
        <div class="card-body">
            @role('administrator')
                <button type="button" class="btn btn-danger">Delete</button>
            @endrole

            @role('teacher')
                <button type="button" class="btn btn-primary">Add</button>
            @endrole

            @role('student')
                <button type="button" class="btn btn-warning">Edit</button>
            @endrole

            
            
            
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>TH-1</th>
                        <th>TH-2</th>
                        <th>TH-3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>TD-01</td>
                        <td>TD-02</td>
                        <td>TD-03</td>
                    </tr>
                    <tr>
                        <td>TD-11</td>
                        <td>TD-12</td>
                        <td>TD-13</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
<!-- /.row -->