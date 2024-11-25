<template>
    <div>
        <div class="d-flex justify-content-end">
            <div class="mt-5">
                <button class="btn btn-primary" v-on:click="createNewData()">
                    Add New Test
                </button>
            </div>
        </div>
        <v-client-table :data="dataTable" :columns="columns" :options="options">
            <template slot="actions" slot-scope="props">
                <div>
                    <button
                        class="btn btn-secondary"
                        v-on:click="editData(props)"
                    >
                        Edit
                    </button>
                </div>
            </template>
        </v-client-table>
        <div
            class="modal fade"
            id="modalTest"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLongTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-if="isEditData == false"
                            class="modal-title"
                            id="exampleModalLongTitle"
                        >
                            Add Test
                        </h5>
                        <h5
                            v-else
                            class="modal-title"
                            id="exampleModalLongTitle"
                        >
                            Edit Test
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-12">
                            <div class="col-12">
                                <label for="">First Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="dataValues.first_name"
                                />
                            </div>

                            <div class="col-12">
                                <label for="">Middle Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="dataValues.middle_name"
                                />
                            </div>

                            <div class="col-12">
                                <label for="">Last Name</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="dataValues.last_name"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            v-on:click="store()"
                        >
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dataValues: {
                first_name: "",
                middle_name: "",
                last_name: "",
            },
            dataTable: [],
            columns: [
                "id",
                "first_name",
                "middle_name",
                "last_name",
                "created_at",
                "updated_at",
                "actions",
            ],
            options: {
                headings: {
                    id: "#",
                    first_name: "First Name",
                    middle_name: "Middle Name",
                    last_name: "Last Name",
                    created_at: "Create At",
                    updated_at: "Updated At",
                    actions: "Action",
                },

                filterable: true,
                sortable: "id",
            },

            first_name: "",
            middle_name: "",
            last_name: "",
            isEditData: false,
        };
    },

    methods: {
        getRecords() {
            axios.get("test/get_records").then((response) => {
                this.dataTable = response.data.data;
            });
        },

        createNewData() {
            this.isEditData = false;
            this.dataValues = {
                first_name: "",
                middle_name: "",
                last_name: "",
            };
            $("#modalTest").modal("show");
        },

        store() {
            axios
                .post("test/store", this.dataValues)
                .then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    $("#modalTest").modal("hide");
                    this.getRecords();
                })
                .catch((error) => {
                    // this.handleError(error);
                });
        },

        editData(props) {
            this.isEditData = true;
            $("#modalTest").modal("show");
        },
    },

    mounted() {
        this.getRecords();
    },
};
</script>
