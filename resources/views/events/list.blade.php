<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <title>Events List</title>
   </head>
   <body>
      <div class="container">
      <h4 class="text-center mt-4">Events List</h3>
         <div class="row mt-5">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     @if(isset($data) && count($data) > 0)
                        <form action="" method="GET">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search by employee name" id="searchEmployee">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text" id="basic-addon1">
                                          <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg" alt="">
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search by event name" id="searchEvent">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text" id="basic-addon2">
                                          <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg" alt="">
                                       </span>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="yyyy-mm-dd" id="searchDate">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text" id="basic-addon3">
                                          <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg" alt="">
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                        <table class="table table-striped table-inverse table-responsive d-table">
                           <thead>
                              <tr>
                                 <th><strong> Participation ID </strong></th>
                                 <th><strong> Employee Name </strong></th>
                                 <th><strong> Employee Email </strong></th>
                                 <th><strong> Event Name </strong></th>
                                 <th><strong> Event Date </strong></th>
                                 <th><strong> Participation Fee </strong></th>
                                 <th><strong> Version </strong></th>
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
                                    <td>  {{ $value->version ? $value->version : '' }} </td>
                                 </tr>
                              @endforeach
                              <tr>
                                 <td></td>
                                 <td></td>
                                 <td> </td>
                                 <td></td>
                                 <td> </td>
                                 <td>Total price</td>
                                 <td> {{ $totalPrice }} </td>
                              </tr>
                           </tbody>
                        </table>
                     @else
                        <h2>
                           {{ 'No data.' }}
                        </h2>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script>
         $('#searchEmployee').on('keyup', function() {
            search();
         });
         $('#searchEvent').on('keyup', function() {
            search();
         });
         $('#searchDate').on('keyup', function() {
            search();
         });
         function search () {
            let employeeName = $('#searchEmployee').val();
            let eventName = $('#searchEvent').val();
            let eventDate = $('#searchDate').val();
            $.get('{{ route("events.search") }}',
               {
                  employeeName,
                  eventName,
                  eventDate
               },
               (data) => {
                  table_post_row(data);
               });
         }
         // table row with ajax
         function table_post_row (res) {
            let htmlView = '';
            let data = res.data;
            let totalPrice = res.totalPrice;
            if (data.length <= 0) {
               htmlView+= `
                  <tr>
                     <td colspan="7">No data.</td>
                  </tr>
               `;
            }
            for (let i = 0; i < data.length; i++) {
               let version = '';
               if (data[i].version) {
                  version = data[i].version;
               }
               htmlView +=
                  `<tr>
                     <td>`+ data[i].participation_id +`</td>
                     <td>`+ data[i].employee_name +`</td>
                     <td>`+ data[i].employee_mail +`</td>
                     <td>`+ data[i].event_name +`</td>
                     <td>`+ data[i].event_date +`</td>
                     <td>`+ data[i].participation_fee +`</td>
                     <td>`+ version +`</td>
                  </tr>`;
            }
            htmlView += 
            `<tr>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td> Total price </td>
               <td>`+  totalPrice +`</td>
            </tr>`;
            $('tbody').html(htmlView);
         }
      </script>
   </body>
</html>