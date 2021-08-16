<template>
    <div>
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Pending Contracts</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Pending Contracts
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <table id="contracts-table" class="table table-hover" style="width: 100%"></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Overview Modal -->
        <div id="contract-overview-modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract Overview Of {{ other_details.type }} <u>{{ other_details.custom_id }}</u></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-auto m-1 border p-3" v-for="item in contents">
                                <span class="me-4">{{ item.label }}</span>
                                <button class="btn btn-primary" @click="viewImage(item.value)">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success text-white" @click="approve">Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contract Image Modal -->
        <div id="contract-image-modal" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Contract Overview Of <u>{{ other_details.custom_id }}</u></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img v-bind:src="'/storage/' + image_path" style="width:100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Contracts",
        props: ['data'],
        data() {
            return {
                dt: null,
                contents: {},
                other_details: {},
                image_path: '',
                contract_overview_modal: null,
            }
        },
        methods: {
            showOverview(id) {
                var $this = this;
                axios.post(this.data.contract_overview_link, {id: id}).then(function (value) {
                    $this.contents = value.data.contents;
                    $this.other_details = value.data.other;
                    $this.contract_overview_modal.show();
                });
            },
            viewImage(link) {
                this.image_path = link;
                this.contract_image_modal.show()
            },
            approve(){
                var $this = this;
                alertify.confirm("Approval Confirmation", "Do you confirm?",
                    function(){
                        axios.post($this.data.contracts_approval, $this.other_details).then(function () {

                            $this.contract_overview_modal.hide();
                            $this.dt.draw();
                            alertify.alert("You successfully approved the contract!", function(){
                                    window.location = '/contracts';
                                });
                        });
                    },
                    function(){
                        alertify.error('Cancel');
                    });
            }
        },
        mounted() {
            var $this = this;

            $this.contract_overview_modal = new bootstrap.Modal(document.getElementById('contract-overview-modal'), {
                keyboard: false
            });

            $this.contract_image_modal = new bootstrap.Modal(document.getElementById('contract-image-modal'), {
                keyboard: false
            });

            $this.dt = $('#contracts-table').DataTable({
                serverSide: true,
                ajax: {
                    url: $this.data.contract_pending_table_link,
                    type: 'POST'
                },
                "order": [[0, "desc"]],
                "columns": [
                    {
                        "data": function (value) {
                            return '<button type="button" class="btn-custom-id btn btn-sm btn-link">' +
                                value.custom_id + '</button>';
                        }, "name": "custom_id", "title": "Contract No."
                    },
                    {"data": 'type', "name": "type", "title": "Type"},
                    {"data": 'status', "name": "ca.status", "title": "Status"},
                    {"data": 'creator.name', "name": "creator.name", "title": "Sent By"},
                    {"data": 'created_at', "name": "created_at", "title": "Date Submitted"},
                ],
                drawCallback: function (settings) {
                    $('body .btn-custom-id').on('click', function () {
                        $this.showOverview($this.dt.row($(this).parent()).data().id);
                    });
                }
            });
        }
    }
</script>

<style scoped>

</style>
