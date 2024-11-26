<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Department
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>Departments</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New Department
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
                    <button
                        class="btn btn-danger"
                        v-on:click="destroyData(row)"
                    >
                        Delete
                    </button>
                </template>
            </v-client-table>

            <div class="modal" id="create-department">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create Department
                            </p>
                            <p v-else class="modal-title">Edit Department</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="company_id">Company:</label>
                                <select
                                    id="company_id"
                                    class="form-control"
                                    v-model="company_id"
                                    :class="{
                                        'border border-danger':
                                            errors.company_id,
                                    }"
                                >
                                    <option
                                        v-for="company in company"
                                        :value="company.company_id"
                                    >
                                        {{ company.name }}
                                    </option>
                                </select>
                                <p class="text-danger" v-if="errors.company_id">
                                    {{ errors.company_id[0] }}
                                </p>

                                <label for="name">Department:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    placeholder="Input Department name here"
                                    :class="{
                                        'border border-danger': errors.name,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </p>

                                <label for="name">Budget:</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="budget"
                                    placeholder="Input Department's Budget here"
                                    :class="{
                                        'border border-danger': errors.budget,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.budget">
                                    {{ errors.budget[0] }}
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
export default {
    components: {
        Loading,
    },
    props: ["company"],
    data() {
        return {
            department_id: "",
            company_id: "",
            name: "",
            budget: "",
            creation_date: "",
            errors: "",
            isEditData: false,
            isLoading: false,
            fullPage: true,
            dataTable: [],
            columns: [
                "department_id",
                "company_name",
                "name",
                "budget",
                "creation_date",
                "actions",
            ],
            options: {
                headings: {
                    department_id: "ID",
                    company_name: "Company Name",
                    name: "Department Name",
                    budget: "Budget",
                    creation_date: "Creation Date",
                    actions: "Actions",
                },
                filterable: true,
                sortable: ["department_id", "name"],
            },
        };
    },
    methods: {
        init() {
            (this.company_id = ""), (this.name = "");
            this.budget = "";
            this.creation_date = "";
            this.errors = [];
        },
        show() {
            axios.get("department/show").then((response) => {
                console.log(response);
                this.dataTable = response.data.data;
            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-department").modal("show");
        },
        closeModal() {
            $("#create-department").modal("hide");
            this.init();
        },
        store() {
            this.isLoading = true;
            axios
                .post("department/store", {
                    company_id: this.company_id,
                    name: this.name,
                    budget: this.budget,
                    creation_date: this.creation_date,
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
                }).finally(() => {
                    this.isLoading = false;
                });
        },
        editData(data) {
            this.isEditData = true;
            this.department_id = data.row.department_id;
            this.company_id = data.row.company_id;
            this.name = data.row.name;
            this.budget = data.row.budget;
            
            $("#create-department").modal("show");
        },
        updateData() {
            this.isLoading = true;
            axios
                .put("/department/update/" + this.department_id, {
                    company_id: this.company_id,
                    name: this.name,
                    budget: this.budget,
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
                }).finally(() => {
                    this.isLoading = false;
                });
        },
        destroyData(data) {
            if (confirm("Are you sure you want to delete this data?")) {
                axios
                    .get("department/destroy/" + data.row.department_id)
                    .then((response) => {
                        this.$fire({
                            title: "Success",
                            text: response.data.message,
                            type: "success",
                            timer: 3000,
                        });
                        this.show();
                    });
            }
        },
    },
    mounted() {
        this.show();
    },
};
</script>
