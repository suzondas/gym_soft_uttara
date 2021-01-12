<link rel="stylesheet" type="text/css"
      href="https://cdn.datatables.net/w/dt/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/w/dt/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
<?php $session = $this->request->session()->read("User"); ?>
<script type="text/javascript">
    $(function () {
        $(document).tooltip();
    });
    $(document).ready(function () {
        jQuery(".expense_form").validationEngine();
        jQuery('#payment_list').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', {
                    extend: 'pdfHtml5',
                    orientation: 'landscape'
                }
            ],
            "responsive": true,
            "order": [[0, "asc"]],
            "aoColumns": [
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true},
                {"bSortable": true, "sWidth": "1"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true, "sWidth": "5px"},
                {"bSortable": true},
                {"bSortable": false}],
            "columnDefs": [
                {
                    "targets": [3],
                    "visible": false,
                    "searchable": false
                }
            ],
            "language": {<?php echo $this->Gym->data_table_lang();?>},
            "rowCallback": function(row, data, index){
                if(data[9] === '[Expired]'){
                    console.log('m')
                    $(row).find('td:eq(8)').css('color', 'red');
                    $(row).find('td:eq(8)').addClass('redExpired');
                }
            }
        });


        $("#paidFilter").on('change', function () {
            var table = $('#payment_list').DataTable();
            table
                .columns(10)
                .search($('#paidFilter').val())
                .draw();
        })

        $("#memberTypeFilter").on('change', function () {

            var table = $('#payment_list').DataTable();
            table
                .columns(9)
                .search($("#memberTypeFilter").val())
                .draw();
        })
        $(".filterDTPaidAll").on('click', function () {
            $('#payment_list').DataTable();
            $('#payment_list').DataTable().destroy();
            $('#payment_list').DataTable().draw();
        });


        function formatDate(date) {
            var from = date.split("/")
            return new Date(from[2], from[1] - 1, from[0])
        }

        var k = function (settings, data, dataIndex) {
            var min = null;
            var max = null;
            var date = new Date();
            var value = $("#eDFTM").val();
            if (value === 'month') {
                min = new Date(date.getFullYear(), date.getMonth(), 1);
                max = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            } else if (value === 'week') {
                var curr = new Date;
                min = new Date(curr.setDate(curr.getDate() - curr.getDay()));
                max = new Date(curr.setDate(curr.getDate() - curr.getDay() + 6));
            }
            else if (value === 'lastWeek') {
                var curr = new Date;
                max = new Date(curr.setDate(curr.getDate()));
                min = new Date(curr.setDate(curr.getDate() - 7));
            }
            else if (value === 'today') {
                var curr = new Date;
                min = max = new Date(curr.setDate(curr.getDate() -1));
                max = new Date(curr.setDate(curr.getDate() + 1));
            } else {
                var min = null;
                var max = null;
            }


            // need to change str order before making  date obect since it uses a new Date("mm/dd/yyyy") format for short date.
            var startDate = formatDate(data[8]);

            if (min == null && max == null) {
                return true;
            }
            if (min == null && startDate <= max) {
                return true;
            }
            if (max == null && startDate >= min) {
                return true;
            }
            if (startDate <= max && startDate >= min) {
                return true;
            }
            return false;
        };
        /*Expired Date Filter*/

        $("#eDFTM").on('change', function () {

            $.fn.dataTable.ext.search.push(k)
            $('#payment_list').DataTable().draw();
        });
    });
</script>
<style>
    .redExpired{
        color : red !important;
    }
    #payment_list .btn {
        padding: 0px !important;
    }

    .notPaid {
        background: #f9932a;
    }

    .paid {
        background: green;
    }

    .partiallyPaid {
        background: #ffc600;
    }

    .filterDTPaidAll {
        background: dodgerblue;
    }

    .expired {
        color: #ff6767 !important;
    }
</style>
<section class="content">
    <br>
    <div class="col-md-12 box box-default">
        <div class="box-header">
            <section class="content-header">
                <h1>
                    <i class="fa fa-plus"></i>
                    <?php echo __("Payment"); ?>
                    <small><?php echo __("Workout Daily"); ?></small>
                </h1>
                <?php
                if ($session["role_name"] == "administrator") { ?>
                    <ol class="breadcrumb">
                        <a href="<?php echo $this->Gym->createurl("MembershipPayment", "generatePaymentInvoice"); ?>"
                           class="btn btn-flat btn-custom"><i
                                    class="fa fa-bars"></i> <?php echo __("Generate Payment Invoice"); ?></a>
                    </ol>
                <?php } ?>
            </section>
        </div>
        <hr>
        <h4 style="color:#1DB198;">Filter Members - </h4>
        Payment:
        <select id="paidFilter">
            <option value="">All</option>
            <option class="" value="Fully Paid">Fully Paid</option>
            <option class="" value="Partially Paid">Partially Paid</option>
            <option class="" value="Not Paid">Not Paid</option>
        </select>
        &nbsp;|&nbsp;
        Member Type:
        <select id="memberTypeFilter">
            <option value="">All</option>
            <option class="" value="[Expired]">Expired Member</option>
            <option class="" value="[----]">Active Member</option>
        </select>
        &nbsp;|&nbsp;
        Expiry
        <select id="eDFTM">
            <option class="" value="all">No Bound</option>
            <option class="" value="month">This Month</option>
            <option class="" value="week">This Week</option>
            <option class="" value="lastWeek">Last Week</option>
            <option class="" value="today">Today</option>
        </select>

        <hr>

        <div class="box-body">

            <table id="payment_list" class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th><?php echo __('ID', 'gym_mgt'); ?></th>
                    <th><?php echo __('Title', 'gym_mgt'); ?></th>
                    <th><?php echo __('Member Name', 'gym_mgt'); ?></th>
                    <th><?php echo __('Mobile', 'gym_mgt'); ?></th>
                    <th><?php echo __('Discounted Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Paid Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Due Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Membership Start Date', 'gym_mgt'); ?></th>
                    <th><?php echo __('Membership End Date', 'gym_mgt'); ?></th>
                    <th><?php echo __('Expiry', 'gym_mgt'); ?></th>
                    <th><?php echo __('Payment Status', 'gym_mgt'); ?></th>
                    <th><?php echo __('Action', 'gym_mgt'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                function checkDateGreater($date)
                {
                    $date_now = new DateTime();
                    $date2 = new DateTime($date);
                    if ($date_now > $date2) {
                        return "Expired";
                    } else {
                        return "----";
                    }
                }

                function convertDate($date)
                {
                    $d = strtotime($date);
                    $newformat = date('d/m/Y', $d);
                    return $newformat;
                }

                if (!empty($data)) {
                    foreach ($data as $row) {
                        // $due = ($row['membership_amount']- $row['paid_amount'])+($row['membership']['signup_fee']);
                        $due = ($row['discount_amount'] - $row['paid_amount']);
                        if (__($this->Gym->get_membership_paymentstatus($row['mp_id'])) == "Fully Paid") {
                            $paymentCss = "paid";
                        } elseif (__($this->Gym->get_membership_paymentstatus($row['mp_id'])) == "Not Paid") {
                            $paymentCss = "notPaid";
                        } else {
                            $paymentCss = "partiallyPaid";
                        }
                        echo "<tr class='" . checkDateGreater($row["end_date"]) . "'>
								<td>{$row['gym_member']['member_id']}</td>
								<td>{$row['membership']['membership_label']}</td>
								<td>{$row['gym_member']['first_name']} {$row['gym_member']['last_name']}</td>
								<td>{$row['gym_member']['mobile']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$row['discount_amount']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$row['paid_amount']}</td>
								<td>" . $this->Gym->get_currency_symbol() . " {$due}</td>
								<td>" . convertDate($row['start_date']) . "</td>
								<td>" . convertDate($row['end_date']) . "</td>
								<td>[" . checkDateGreater($row["end_date"]) . "]</td>
								<td><span class='bg-primary pay_status " . $paymentCss . "'>" . __($this->Gym->get_membership_paymentstatus($row['mp_id'])) . "<span></td>
								<td>
								<a href='javascript:void(0)' class='btn btn-flat btn-info view_invoice' data-url='" . $this->request->base . "/GymAjax/viewInvoice/{$row['mp_id']}'><i class='fa fa-eye'></i></a>";
                        if ($session["role_name"] == "administrator") {
                            echo " <a href='javascript:void(0)' class='btn btn-flat btn-default amt_pay' data-url='" . $this->request->base . "/GymAjax/gymPay/{$row['mp_id']}'>" . __('Pay') . "</a>
                                    <a href='" . $this->request->base . "/MembershipPayment/MembershipEdit/{$row['mp_id']}' class='btn btn-flat btn-primary' title='Edit'><i class='fa fa-edit'></i></a>
									<a href='" . $this->request->base . "/MembershipPayment/deletePayment/{$row['mp_id']}' class='btn btn-flat btn-danger' onclick=\"return confirm('Are you sure,You want to delete this record?')\"><i class='fa fa-trash'></i></a>";
                        }
                        echo "</td>
						</tr>";
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th><?php echo __('ID', 'gym_mgt'); ?></th>
                    <th><?php echo __('Title', 'gym_mgt'); ?></th>
                    <th><?php echo __('Member Name', 'gym_mgt'); ?></th>
                    <th><?php echo __('Mobile', 'gym_mgt'); ?></th>
                    <th><?php echo __('Discounted Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Paid Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Due Amount', 'gym_mgt'); ?></th>
                    <th><?php echo __('Membership Start Date', 'gym_mgt'); ?></th>
                    <th><?php echo __('Membership End Date', 'gym_mgt'); ?></th>
                    <th><?php echo __('Expiry', 'gym_mgt'); ?></th>
                    <th><?php echo __('Payment Status', 'gym_mgt'); ?></th>
                    <th><?php echo __('Action', 'gym_mgt'); ?></th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
</section>