<template>
    <div class="pt-3">
        <div class="card p-5">
            <h2 class="title-header">Asset Group</h2>
            <button
                v-on:click="createAssetGroup"
                class="add-btn"
                style="
                    background-color: #0023a3;
                    color: white;
                    border-radius: 5px;
                "
            >
                + Create New Asset Group
            </button>
            <div class="row">
                <div class="col-md-12">
                    <v-client-table
                        :data="tableData"
                        :columns="columns"
                        :options="options"
                    >
                        <template slot="actions" slot-scope="row">
                            <button
                                class="btn btn-link text-green"
                                style="font-size: 13px; font-weight: 600"
                                v-on:click="editAssetGroup(row.row.id)"
                            >
                                <i class="fas fa-edit mr-2"></i> Edit
                            </button>
                            <button
                                class="btn btn-link text-red"
                                style="font-size: 13px; font-weight: 600"
                                v-on:click="deleteAssetGroup(row.row.id)"
                            >
                                <i
                                    class="fa fa-trash mr-2"
                                    aria-hidden="true"
                                ></i>
                                Delete
                            </button>
                        </template>
                    </v-client-table>
                </div>
            </div>
        </div>

        <div class="modal" id="create-asset-group-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form
                        @submit.prevent="submitForm"
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body p-1">
                            <h5
                                class="modal-title text-center pt-4"
                                style="font-weight: bold"
                            >
                                Add New Asset Group
                            </h5>
                            <div class="container mb-5">
                                <div class="row pt-5 pl-5 pr-5">
                                    <div class="col-md-12">
                                        <label>Group Code</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="formData.group_code"
                                        />
                                        <span
                                            style="font-size: 12px; color: red"
                                            :error="errors"
                                            v-if="errors.group_code"
                                            >{{ errors.group_code[0] }}</span
                                        >
                                    </div>
                                </div>
                                <div class="row pl-5 pr-5">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="formData.description"
                                        />
                                        <span
                                            style="font-size: 12px; color: red"
                                            :error="errors"
                                            v-if="errors.description"
                                            >{{ errors.description[0] }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="w-75" style="margin: 0 auto">
                                <div
                                    class="pt-2 pb-5 w-100 row justify-content-center"
                                >
                                    <div class="col-md-6">
                                        <button
                                            class="btn btn-outline-secondary w-100"
                                            type="button"
                                            data-bs-dismiss="modal"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button
                                            class="btn w-100"
                                            type="submit"
                                            style="
                                                background: #070151;
                                                color: white;
                                            "
                                        >
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="vld-parent">
            <loading
                :active="isLoading"
                :can-cancel="false"
                :is-full-page="fullPage"
            >
            </loading>
        </div>
    </div>
</template>

<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    data() {
        return {
            imageData: null,
            columns: ["id", "group_code", "description", "actions"],
            tableData: [],
            options: {
                headings: {
                    id: "ID",
                    group_code: "Group Code",
                    description: "Description",
                    actions: "Actions",
                },
                sortable: ["group_code", "description"],
                filterable: ["group_code", "description"],
                templates: {
                    hol_date: function (h, row) {
                        return row.hol_date !== null
                            ? moment(row.hol_date).format("YYYY-MM-DD")
                            : null;
                    },
                    created_at: function (h, row) {
                        return row.created_at !== null
                            ? moment(row.created_at).format(
                                  "YYYY-MM-DD hh:mm:ss"
                              )
                            : null;
                    },
                    updated_at: function (h, row) {
                        return row.updated_at !== null
                            ? moment(row.updated_at).format(
                                  "YYYY-MM-DD hh:mm:ss"
                              )
                            : null;
                    },
                },
                texts: {
                    filter: "Search:",
                },
            },
            errors: [],
            isCreate: false,
            formData: {
                id: null,
                group_code: null,
                description: null,
            },
            isLoading: false,
            fullPage: true,
        };
    },
    components: {
        Loading,
    },
    methods: {
        loadRecords() {
            this.isLoading = true;

            axios
                .get("/asset_group/getRecords")
                .then(
                    function (res) {
                        this.tableData = res.data.user;
                    }.bind(this)
                )
                .finally(() => {
                    this.isLoading = false;
                });
        },

        createAssetGroup() {
            $("#create-asset-group-modal").modal("show");
            this.formData.group_code = null;
            this.formData.description = null;
            this.isCreate = true;
        },

        submitForm() {
            axios
                .post("/asset_group/store", this.formData)
                .then((response) => {
                    // Close modal and show success message
                    $("#create-asset-group-modal").modal("hide");
                    this.$toastr.Add({
                        title: "System Info",
                        msg: response.data.message,
                        clickClose: false,
                        timeout: 3000,
                        progressBarValue: 0,
                        position: "toast-top-right",
                        type: "success",
                        preventDuplicates: true,
                        classNames: ["animated", "zoomInUp"],
                    });
                    this.loadRecords();
                })
                .catch((error) => {
                    // Handle validation errors
                    if (
                        error.response &&
                        error.response.status === 400 &&
                        error.response.data.message === "Group Code already exists"
                    ) {
                        // Show specific notification for duplicate email
                        this.$toastr.Add({
                            title: "Duplicate Entry",
                            msg: "This Group Code is already exists.",
                            clickClose: false,
                            timeout: 3000,
                            progressBarValue: 0,
                            position: "toast-top-right",
                            type: "warning",
                            preventDuplicates: true,
                            classNames: ["animated", "zoomInUp"],
                        });
                    } else if (error.response && error.response.data.errors) {
                        // Show validation errors if present
                        this.errors = error.response.data.errors;
                    } else {
                        // Show generic error message
                        this.messageBox(
                            "Error",
                            "Something went wrong!",
                            "error"
                        );
                    }
                });
        },

        submitForm2() {
            axios
                .post("/asset_group/update", this.formData)
                .then((response) => {
                    // Close modal and show success message
                    $("#show-modal").modal("hide");
                    this.$toastr.Add({
                        title: "System Info",
                        msg: response.data.message,
                        clickClose: false,
                        timeout: 3000,
                        progressBarValue: 0,
                        position: "toast-top-right",
                        type: "success",
                        preventDuplicates: true,
                        classNames: ["animated", "zoomInUp"],
                    });
                    this.loadRecords();
                })
                .catch((error) => {
                    // Handle duplicate email error
                    if (
                        error.response &&
                        error.response.status === 400 &&
                        error.response.data.message === "Group Code already exists"
                    ) {
                        this.$toastr.Add({
                            title: "Duplicate Entry",
                            msg: "This Group Code is already exists.",
                            clickClose: false,
                            timeout: 3000,
                            progressBarValue: 0,
                            position: "toast-top-right",
                            type: "warning",
                            preventDuplicates: true,
                            classNames: ["animated", "zoomInUp"],
                        });
                    } else if (error.response && error.response.data.errors) {
                        // Show validation errors if present
                        this.errors = error.response.data.errors;
                    } else {
                        // Show generic error message
                        this.messageBox(
                            "Error",
                            "Something went wrong!",
                            "error"
                        );
                    }
                });
        },

        editAssetGroup(id) {
            axios.get("/asset_group/edit/" + id).then((response) => {
                this.isCreate = false;
                this.formData = response.data.data;
                $("#create-asset-group-modal").modal("show");
            });
        },

        deleteAssetGroup(id) {
            if (confirm("Do you really want to delete?")) {
                axios.get("/asset_group/destroy/" + id).then((response) => {
                    // $("#show-modal").modal("hide");
                    this.$toastr.Add({
                        title: "System Info",
                        msg: response.data.message,
                        clickClose: false,
                        timeout: 3000,
                        progressBarValue: 0,
                        position: "toast-top-right",
                        type: "success",
                        preventDuplicates: true,
                        classNames: ["animated", "zoomInUp"],
                    });
                    this.loadRecords();
                    // this.messageBoxWithReload('Deleted', 'Data Successfully Deleted!', 'success');
                });
            }
        },
    },

    mounted() {
        this.isLoading = false;
        this.loadRecords();
    },
};
</script>

<style scoped>
.add-btn {
    border: none;
    width: 125px;
    height: 40px;
    transform: translate(170%, 100%);
    z-index: 1;
}
.card {
    border-radius: 10px;
}
.title-header {
    font-weight: bold;
    margin: 0;
    padding: 0;
    font-size: 30px;
}
.VueTables__search-field label {
    display: none;
}

.base-image-input {
    display: block;
    width: 200px;
    height: 200px;
    cursor: pointer;
    background-size: cover;
    background-position: center center;
}
.placeholder {
    background: #f0f0f0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333;
    font-size: 18px;
    font-family: Helvetica;
}
.placeholder:hover {
    background: #e0e0e0;
}
.file-input {
    display: none;
}
</style>
