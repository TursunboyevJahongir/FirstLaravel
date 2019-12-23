<table class="table table-bordered">
    <thead>
    <tr>
        <th width="100px">ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data ?? '' as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

{!! $data ?? ''->render() !!}
