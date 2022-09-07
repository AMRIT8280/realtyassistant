	<?php 
include_once("../../connection.php");
if($_SESSION['admin_user_id']=='')					redirect('index');

?>
        <!-- Bootstrap Core JavaScript -->
        <script src="<?=URL?>assets/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="<?=URL?>assets/js/metisMenu.min.js"></script>
        
        <!-- Datepicker jquery -->
        <script src="<?=URL?>assets/js/bootstrap-datepicker.min.js"></script>

        
        <!-- DataTables JavaScript -->
        <script src="<?=URL?>assets/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/dataTables.bootstrap.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/dataTables.buttons.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/buttons.bootstrap4.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/jszip.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/pdfmake.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/vfs_fonts.js"></script>
        <script src="<?=URL?>assets/js/dataTables/buttons.html5.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/buttons.print.min.js"></script>
        <script src="<?=URL?>assets/js/dataTables/buttons.colVis.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="<?=URL?>assets/js/startmin.js"></script>
        
        <!--begin::Page Vendors(used by this page) -->
		<script src="<?=URL?>assets/js/tinymce/tinymce.bundle.js" type="text/javascript"></script>
        <script src="<?=URL?>assets/js/tinymce/tinymce.js" type="text/javascript"></script>

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script src="<?=URL?>assets/js/jquery-validation/additional-methods.js" type="text/javascript"></script>
        
        <script type="text/javascript">
			$('.tooltip-demo').tooltip({
				selector: "[data-toggle=tooltip]",
				container: "body"
			})
		
			// popover demo
			$("[data-toggle=popover]").popover()
            $(document).ready(function() {
				/*-----------------------------Cheak Function------------------------------------*/
				$(".cheak_all").click(function(){
				   if($('.cheak_all:checked').length){
					  
					  $("#on_option").css('display','block');
					  }
					 else{
						  $("#on_option").css('display','none')
						 }
				  
				  })
				/*-----------------------------DataTables------------------------------------*/
				  $('#dataTables-example').DataTable({
                        responsive: true
                });
                
				/*-----------------------------Datepicker------------------------------------*/
				$(".multi_date").datepicker({
					startDate: new Date(),
					format: 'dd/mm/yyyy',
				  	multidate: true,
                    clearBtn: true,
                    todayHighlight: true,
					closeOnDateSelect: true
				});
				/*-------------------------------Data Export----------------------------------*/
				$('#export_table').DataTable({
					"processing": true,
					"dom": "<'row'<'col-sm-2'l><'col-sm-6'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
					"buttons": [
						{
							extend: 'collection',
							text: 'Export To&nbsp; <b class="caret"></b>',
							buttons: [{
							  extend: 'pdf',							  
							  header : true,
							  footer : false,
							  exportOptions : {
							   columns : [ 1, 2, 3],
							   search: 'applied',
							   order: 'applied'
							  },
							  title: '<?=SITETITLE?>',
							  filename: '<?=SITETITLE?>'
							}, {
							  extend: 'excel',
							  exportOptions : {
							   columns : [ 1, 2, 3]
							  },
							  title: '<?=SITETITLE?>',
							  filename: '<?=SITETITLE?>'
							}, {
							  extend: 'csv',
							  exportOptions : {
							   columns : [ 1, 2, 3]
							  },
							  title: '<?=SITETITLE?>',
							  filename: '<?=SITETITLE?>'
							}, {
							  extend: 'print',
							  text: 'Print',
							  title: '<?=SITETITLE?>',
							  filename: '<?=SITETITLE?>',
							  exportOptions : {
							   columns : [ 1, 2, 3]
							  },
							  customize: function(win) {
								  $(win.document.body)
									.prepend(
										'<img src="<?php echo BASE_URL.'uploads/admin/'.get_siteconfig('logo'); ?>" style="position:absolute; top:0; left:0;width:100px;" />'
									);
									$(win.document.body).find('table')
										.css('margin-top', '100pt');
								 	}
							},]
						}
					],
			  lengthMenu:[
			  	[5,10,25,50,100,-1],
				[5,10,25,50,100,"All"]
			  ]
			});
				/*-------------------------------Value Trim----------------------------------*/
				$('input[type="text"]').change(function() {
					$(this).val($(this).val().trim());
				});
				/*-----------------------------Time out------------------------------------*/
				setTimeout(function() {
					$('#hide_allert').hide('fast');
				}, 10000);
				
            });
        </script>
