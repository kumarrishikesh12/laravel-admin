<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
    <tr>
        <th style="background-color: #000000;" colspan="2">Name</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $key=>$val)
        <tr>
            <td>{{ $val->name }}</td>
            <td>{{ $val->name }}</td>
            <td>{{ $val->category_name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>