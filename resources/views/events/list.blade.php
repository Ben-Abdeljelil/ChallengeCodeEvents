<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<h1>Events list</h1>

@if(count($data) > 0)
<table class="table table-striped table-hover table-reflow">
    <thead>
        <tr>
            <th><strong> Participation ID: </strong></th>
            <th><strong> Employee Name: </strong></th>
            <th><strong> Employee Email: </strong></th>
            <th><strong> Event Name: </strong></th>
            <th><strong> Event Date: </strong></th>
            <th><strong> Participation Fee: </strong></th>
            <th><strong> Version: </strong></th>
        </tr>
    </thead>
    <tbody>
            @foreach($data as $key =>  $value)
                <tr>
                    <td>  {{ $value->participation_id }} </td>
                    <td>  {{ $value->employee_name }} </td>
                    <td>  {{ $value->employee_mail }} </td>
                    <td>  {{ $value->event_name }} </td>
                    <td>  {{ $value->event_date }} </td>
                    <td>  {{ $value->participation_fee }} </td>
                    <td>  {{ $value->version }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2>
        {{ 'Sorry, this events list is empty' }}
    </h2>
@endif