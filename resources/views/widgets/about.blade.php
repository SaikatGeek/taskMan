<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">About This Application</h4>
                   

                    <div class="table-responsive">
                    <div class="form-group">
                        <input type="text" id="search" class="form-control ">          
                    </div>                  

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>Term</th>
                                <th>Details</th>
                                               
                            </tr>
                        </thead>
                   
                   
                        <tbody id="table">
                        <tr>
                        <td>Title</td>
                        <td>SoftX Task Management System</td>
                        </tr>
                        <tr>
                        <td>Current Release</td>
                        <td>v0.0.80 (Beta)</td>
                        </tr>
                        <tr>
                        <td>Release Date</td>
                        <td>13/02/2021</td>
                        </tr>
                        <tr>
                        <td>Implementation</td>
                        <td>
                        Backend - Laravel (PHP) <br>
                        Frontend - HTML, CSS, JS (JQuery) <br>
                        Database - MySQL <br>

                        </td>
                        </tr>
                        <tr>
                        <td>Authorized By</td>
                        <td>Md. Ekramul Huq <br>Chairman</td>
                        </tr>
                        <tr>
                        <td>Supervised By</td>
                        <td>Fahmid Al Nayem <br>CEO  <br>Jahidul Islam <br>CMO</td>
                        </tr>
                        <tr>
                        <td>Project Manager</td>
                        <td>Istiaq Hasan <br>General Manager <br>Engineering Department</td>
                        </tr>
                        <tr>
                        <td>Backend</td>
                        <td>Md. Ariful Islam Saikat <br>Executive Software Engineer <br>Engineering Department</td>
                        </tr>
                        <tr>
                        <td>Frontend</td>
                        <td>Md. Ariful Islam Saikat <br>Executive Software Engineer <br>Engineering Department</td>
                        </tr>
                        <tr>
                        <td>Documentation</td>
                        <td>Saima Afrin <br>Junior Executive, System Analyst & QA <br>Engineering Department</td>
                        </tr>
                       
                        </tbody>
                    </table>
                </div>

         

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->

    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $( document ).ready(function() {
       
      var $rows = $('#table tr');
      $('#search').keyup(function() {
          var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
         
          $rows.show().filter(function() {
              var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
              return !~text.indexOf(val);
          }).hide();
});        
       
    });
</script>
@endpush