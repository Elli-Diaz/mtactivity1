<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Company
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>Companies</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New Company
                    </button>
                </div>
            </div>
            <v-client-table
                :data="dataTable"
                :columns="columns"
                :options="options"
            >
                <template slot="actions" slot-scope="row">
                    <button
                        class="btn btn-secondary"
                        v-on:click="editData(row)"
                    >
                        Edit
                    </button>
                    <button class="btn btn-danger" v-on:click="destroyData(row)">Delete</button>
                </template>
            </v-client-table>

            <!-- Modal: -->
            <div class="modal" id="create-company">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="text-center modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create Company
                            </p>

                            <p v-else class="modal-title">Edit Company</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Company Name:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Input company name here"
                                    :class="{
                                        'border border-danger': errors.name,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </p>
                                <label for="address">Company Address:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="address"
                                    placeholder="Input company address here"
                                    :class="{
                                        'border border-danger': errors.address,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.address">
                                    {{ errors.address[0] }}
                                </p>
                                <label for="established_date">Company Established Date:</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="established_date"
                                    placeholder="Input company established date here"
                                    :class="{
                                        'border border-danger': errors.established_date,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.established_date">
                                    {{ errors.established_date[0] }}
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-outline-danger"
                                v-on:click="closeModal"
                            >
                                Cancel
                            </button>
                            <button
                                class="btn btn-primary"
                                v-on:click="store"
                                v-if="!isEditData"
                            >
                                Save
                            </button>
                            <button
                                class="btn btn-primary"
                                v-on:click="updateData"
                                v-else
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vld-parent" style="z-index: 999999 !important">
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
// import TestComponent from "../TestComponent.vue";
export default {
    components: {
        Loading,
    },
    data() {
        return {
            name: "",
            address: "",
            established_date: "",
            company_id: "",
            errors: "",
            isEditData: false,
            isLoading: false,
            fullPage: true,
            dataTable: [],
            columns: ["company_id", "name", "address", "established_date", "actions"],
            options: {
                headings: {
                    company_id: "ID",
                    name: "Company Name",
                    address: "Company Address",
                    established_date: "Company Established Date",
                    actions: "Actions",
                },
                filterable: true,
                sortable: ["company_id", "name"],
            },
        };
    },
    methods: {
        init() {
            this.name = "";
            this.address = "";
            this.established_date = "";
            this.errors = [];
        },
        show() {
            axios.get("company/show").then((response) => {
                this.dataTable = response.data.data;
            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-company").modal("show");
        },
        closeModal() {
            $("#create-company").modal("hide");
            this.init();
        },
        store() {
            this.isLoading = true;
            axios
                .post("company/store", {
                    name: this.name,
                    address: this.address,
                    established_date: this.established_date,
                })
                .then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    this.show();
                    this.closeModal();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors.name);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        editData(data) {
            this.isEditData = true;
            this.company_id = data.row.company_id;
            this.name = data.row.name;
            this.address = data.row.address;
            this.established_date = data.row.established_date;
            $("#create-company").modal("show");
        },
        updateData() {
            axios.put("/company/update/" + this.company_id, {
                name: this.name,
                address: this.address,
                established_date: this.established_date,
            })
                .then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    });
                    this.show();
                    this.closeModal();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    console.log(this.errors.name);
                });
                
        },
        destroyData(data){
            if(confirm('Are you sure you want to delete this data?')){
                axios.get('company/destroy/' + data.row.company_id
            ).then((response) => {
                    this.$fire({
                        title: "Success",
                        text: response.data.message,
                        type: "success",
                        timer: 3000,
                    })
                   
                    this.show();
                }).catch((error) => {
                    if (error.response.status = 500){
                        this.$fire({
                        title: "Error",
                        text: "Internal Server Error",
                        type: "warning",
                        timer: 3000,
                    })
                    }
                    
                });
            }
        }
    },
    mounted() {
        this.show();
        this.init();
    },
};
</script>
<style>
.breadcrumb {
    background-color: #f4f6f9;
}
.breadcrumb-link {
    color: #000;
    font-weight: bold;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #28a745;
    font-weight: bold;
}
.modal-header {
    font-weight: bold;
    font-size: 24px;
    background-color: #28a745;
    color: #ffffff;
    padding: 10px 0px 0px 10px;
}
</style>
