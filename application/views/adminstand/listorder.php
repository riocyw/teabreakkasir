 <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="padding: 0px;" class="menujudul">
                List Order Stan
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                  <table id="mytable" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th>ID Order</th>
                        <th>Stan</th>
                        <th>Tanggal Order</th>
                        <th>Detail</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>
        </div> <!-- .content -->

    <!-- Right Panel -->

    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Detail Nota</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label class=" form-control-label"><strong>Status</strong></label>
                                
                                <h4><span class="badge badge-success" id="status_order">SELESAI</span></h4>
                            </div>
                        </div>
                    </div>

                    <!-- DETAIL -->
                    <div class="form-group">
                        <label class=" form-control-label"><strong>Detail Order</strong></label>
                        <table id="detailorder" class="table table-striped table-bordered" style="width: 100%" width="100%"> 
                            <thead>
                              <tr>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                              </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<script src=<?php echo base_url("assets/js/jquery.min.js")?>></script>
<script src=<?php echo base_url("assets/js/lib/vector-map/jquery.vmap.js")?>></script>
<script src=<?php echo base_url("assets/js/lib/vector-map/jquery.vmap.min.js")?>></script>
<script src=<?php echo base_url("assets/js/lib/vector-map/jquery.vmap.sampledata.js")?>></script>
<script src=<?php echo base_url("assets/js/lib/vector-map/country/jquery.vmap.world.js")?>></script>
<script src=<?php echo base_url("assets/datatable/datatables.js")?>></script>
<script src=<?php echo base_url("assets/js/popper.min.js"); ?>></script>
<script src=<?php echo base_url("assets/js/plugins.js"); ?>></script>
<script src=<?php echo base_url("assets/js/teabreak.js"); ?>></script>
<script src=<?php echo base_url("assets/js/lib/chosen/chosen.jquery.min.js"); ?>></script>
<script src=<?php echo base_url("assets/datatable/Buttons-1.5.2/js/dataTables.buttons.js")?>></script>
<script src=<?php echo base_url("assets/datatable/Buttons-1.5.2/js/buttons.print.js")?>></script>
<script src=<?php echo base_url("assets/datatable/Buttons-1.5.2/js/buttons.html5.js")?>></script>
<script src=<?php echo base_url("assets/datatable/Buttons-1.5.2/js/buttons.flash.js")?>></script>
<script src=<?php echo base_url("assets/datatable/JSZip-2.5.0/jszip.js")?>></script>
<script src=<?php echo base_url("assets/datatable/pdfmake-0.1.36/pdfmake.js")?>></script>
<script src=<?php echo base_url("assets/datatable/pdfmake-0.1.36/vfs_fonts.js")?>></script>
<script src=<?php echo base_url("assets/vendors/jsPDF-1.3.2/dist/jspdf.debug.js")?>></script>
<script src=<?php echo base_url("assets/vendors/pdfmake-master/build/pdfmake.min.js")?>></script>
<script src=<?php echo base_url("assets/vendors/pdfmake-master/build/vfs_fonts.js")?>></script>
<script src=<?php echo base_url("assets/js/jquery.easy-autocomplete.js")?>></script>
</body>
</html>

    <script type="text/javascript">
        var tabeldata;

        tabeldata = $("#mytable").DataTable({
              initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .on('.DT')
                .on('keyup.DT', function(e) {
                  if (e.keyCode == 13) {
                    api.search(this.value).draw();
                  }
                });
              },
              oLanguage: {
                sProcessing: "loading..."
              },
              responsive: true,
              ajax: {
                "type"   : "POST",
                // "data": function(data) {
                //   // data.tanggal_awal = $('#tanggal_awal').val();
                //   // data.tanggal_akhir = $('#tanggal_akhir').val();
                //   // data.id_stan = $('#select_stan').val();
                // },
                "url"    : "<?php echo base_url('adminstand/getAllOrder');?>",
                "dataSrc": function (json) {
                  var return_data = new Array();

                  for(var i=0;i< json.data.length; i++){
                    var id =json.data[i].id_order;
                    var stan = id.substr(id.indexOf('ST-')+1);
                    var setdone = "";

                    if (json.data[i].status != 'not_done') {
                        setdone = '<div style="color:green">SELESAI</div>';
                    }else{
                        setdone = '<div style="color:red">BELUM SELESAI</div>';
                    }

                    return_data.push({
                      'id_order': json.data[i].id_order,
                      'id_stan'  : stan,
                      'tanggal_order' : uidate(json.data[i].tanggal_order),
                      'detail' : '<button onclick=detail_order("'+json.data[i].status+'","'+json.data[i].id_order+'") class="btn btn-primary">Detail</button> ',
                      'set_done' : setdone
                    });
                  }
                  return return_data;
                }
              },
                dom: 'Bfrtlip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1,2]
                        }
                    },{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'exportExcel',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1,2]
                        }
                    },{
                        extend: 'csvHtml5',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1,2]
                        }
                    },{
                        extend: 'pdfHtml5',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1,2]
                        }
                    },{
                        extend: 'print',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1,2]
                        }
                    }
                ],
                "lengthChange": true,
                   columns: [
                    {'data': 'id_order'},
                    {'data': 'id_stan'},
                    {'data': 'tanggal_order'},
                    {'data': 'detail'},
                    {'data': 'set_done'}
                  ],
            });

    function reload_table(){
      tabeldata.ajax.reload();
    }

    function detail_order(status,id_order) {
        var stat = '';
        $("#status_order").removeClass('badge-danger');
        $("#status_order").removeClass('badge-success');

        if (status == 'not_done') {
            stat = 'BELUM SELESAI';
            $("#status_order").addClass('badge-danger');
        }else{
            stat = 'SELESAI';
            $("#status_order").addClass('badge-success');
        }

        $('#status_order').html(stat);
        // getSpecificOrderDetail

        if ( $.fn.DataTable.isDataTable( '#detailorder' ) ) {
            $('#detailorder').DataTable().destroy();
        }
        var tabeldetail;

        tabeldetail = $("#detailorder").DataTable({
              initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                .on('.DT')
                .on('keyup.DT', function(e) {
                  if (e.keyCode == 13) {
                    api.search(this.value).draw();
                  }
                });
              },
              oLanguage: {
                sProcessing: "loading..."
              },
              responsive: true,
              ajax: {
                "type"   : "POST",
                "data": function(data) {
                  data.id_order = id_order;
                  // data.tanggal_akhir = $('#tanggal_akhir').val();
                  // data.id_stan = $('#select_stan').val();
                },
                "url"    : "<?php echo base_url('adminstand/getSpecificOrderDetail');?>",
                "dataSrc": function (json) {
                  var return_data = new Array();

                  for(var i=0;i< json.data.length; i++){

                    return_data.push({
                      'nama_bahan_jadi': json.data[i].nama_bahan_jadi,
                      'jumlah'  : json.data[i].jumlah
                    });
                  }
                  return return_data;
                }
              },
                dom: 'Bfrtlip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1]
                        }
                    },{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'exportExcel',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1]
                        }
                    },{
                        extend: 'csvHtml5',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1]
                        }
                    },{
                        extend: 'pdfHtml5',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1]
                        }
                    },{
                        extend: 'print',
                        filename: 'Order Data',
                        exportOptions: {
                          columns:[0,1]
                        }
                    }
                ],
                "lengthChange": true,
                  columns: [
                    {'data': 'nama_bahan_jadi'},
                    {'data': 'jumlah'}
                  ],
            });

        // tabeldetail.columns.adjust();

        $('#modalDetail').modal('toggle');
    }

    function set_done(id_order) {
        if(confirm('Apakah anda yakin ingin mengubah status data ini ?')){
            $.ajax({
                    type:"post",
                    url: "<?php echo base_url('adminfranchise/changeStatusOrderToDone')?>/",
                    data:{ id_order:id_order},
                    success:function(response)
                    {
                         reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                      alert(errorThrown);
                    }
                }
            );
        }
    }
    </script>

