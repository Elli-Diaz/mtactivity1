<template>
    <div class="container-fluid pt-3">
        <div class="header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="breadcrumb-link" href="/">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        User
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card p-4">
            <h3>Users</h3>
            <div class="row">
                <div class="col-md-12 mb-2">
                    <button class="btn btn-primary" v-on:click="showModal">
                        + Create New User
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

            <div class="modal" id="create-employee">
                <div class="modal-dialog modal-dialog-centered bd-example">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p v-if="isEditData == false" class="modal-title">
                                Create User
                            </p>
                            <p v-else class="modal-title">Edit User</p>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="company_id">Company:</label>
                                <select
                                    id="company_id"
                                    class="form-control"
                                    v-model="company_id"
                                    v-on:change="
                                        getDepartmentsByCompany(company_id)
                                    "
                                >
                                    <option
                                        v-for="company in companies"
                                        :value="company.company_id"
                                    >
                                        {{ company.name }}
                                    </option>
                                </select>
                                <p
                                    class="text-danger"
                                    v-if="errors.company_id"
                                >
                                    {{ errors.company_id[0] }}
                                </p>
                                <label for="department_id">Department:</label>
                                <!-- <select
                                    id="department_id"
                                    class="form-control"
                                    v-model="department_id"
                                    :class="{
                                        'border border-danger':
                                            errors.department_id,
                                    }"
                                >
                                    <option
                                        v-for="department in departments"
                                        :value="department.id"
                                    >
                                        {{ department.name }}
                                    </option>
                                </select>
                                <p
                                    class="text-danger"
                                    v-if="errors.department_id"
                                >
                                    {{ errors.department_id[0] }}
                                </p> -->

                                <select
                                    id="department_id"
                                    class="form-control"
                                    v-model="department_id"
                                    :class="{
                                        'border border-danger':
                                            errors.department_id,
                                    }"
                                >
                                    <option
                                        v-for="department in departments"
                                        :value="department.department_id"
                                    >
                                        {{ department.name }}
                                    </option>
                                </select>
                                <p
                                    class="text-danger"
                                    v-if="errors.department_id"
                                >
                                    {{ errors.department_id[0] }}
                                </p>

                                <label for="first_name">First Name:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="first_name"
                                    placeholder="Input User First Name here"
                                    :class="{
                                        'border border-danger':
                                            errors.first_name,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.first_name">
                                    {{ errors.first_name[0] }}
                                </p>

                                <label for="first_name">Last Name:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="last_name"
                                    placeholder="Input User Last Name here"
                                    :class="{
                                        'border border-danger':
                                            errors.last_name,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.last_name">
                                    {{ errors.last_name[0] }}
                                </p>

                                <label for="email">Email:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="email"
                                    placeholder="Input User's Email here"
                                    :class="{
                                        'border border-danger': errors.email,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </p>

                                <label for="phone_number">Phone Number:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="phone_number"
                                    placeholder="Input User's Phone Number here"
                                    :class="{
                                        'border border-danger':
                                            errors.phone_number,
                                    }"
                                />
                                <p
                                    class="text-danger"
                                    v-if="errors.phone_number"
                                >
                                    {{ errors.phone_number[0] }}
                                </p>

                                <label for="job_title">Job Title:</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="job_title"
                                    placeholder="Input User's Job Title here"
                                    :class="{
                                        'border border-danger':
                                            errors.job_title,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.job_title">
                                    {{ errors.job_title[0] }}
                                </p>

                                <label for="hire_date">Hired Date:</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="hire_date"
                                    placeholder="Input User's Hired Date here"
                                    :class="{
                                        'border border-danger':
                                            errors.hire_date,
                                    }"
                                />
                                <p class="text-danger" v-if="errors.hire_date">
                                    {{ errors.hire_date[0] }}
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
    </div>
</template>
<script>
export default {
    props: ["companies"],
    data() {
        return {
            id: "",
            department_id: "",
            company_id: "",
            first_name: "",
            last_name: "",
            email: "",
            phone_number: "",
            job_title: "",
            hire_date: "",
            department_name: "",
            company_name: "",
            departments: [],
            errors: "",
            isEditData: false,
            dataTable: [],
            columns: [
                "id",
                "department_name",
                "company_name",
                "first_name",
                "last_name",
                "email",
                "phone_number",
                "job_title",
                "hire_date",
                "actions",
            ],
            options: {
                headings: {
                    id: "ID",
                    department_name: "Department Name",
                    company_name: "Company Name",
                    first_name: "First Name",
                    last_name: "Last Name",
                    email: "Email",
                    phone_number: "Phone Number",
                    job_title: "Job Title",
                    hire_date: "Hired Date",
                    actions: "Actions",
                },
                filterable: true,
                sortable: ["id", "first_name", "last_name"],
            },
        };
    },
    methods: {
        init() {
            this.department_id = "";
            this.company_id = "";
            this.first_name = "";
            this.last_name = "";
            this.email = "";
            this.phone_number = "";
            this.job_title = "";
            this.hire_date = "";
            this.departments = [];
            this.errors = [];
        },
        show() {
            axios.get("employee/show").then((response) => {
                this.dataTable = response.data.data;
            });
        },
        showModal() {
            this.isEditData = false;
            this.init();
            $("#create-employee").modal("show");
        },
        closeModal() {
            this.init();
            $("#create-employee").modal("hide");
        },
        store() {
            axios
                .post("employee/store", {
                    department_id: this.department_id,
                    company_id: this.company_id,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    phone_number: this.phone_number,
                    job_title: this.job_title,
                    hire_date: this.hire_date,
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
                });
        },
        getDepartmentsByCompany(company_id) {
            console.log(company_id)
            axios
                .get("employee/getDepartmentsByCompany/" + company_id)
                .then((response) => {
                    this.departments = response.data.department;   
             })
                .catch((error) => {
                    this.errors.department_id = [
                        "Failed to fetch departments.",
                    ];
                });
        },

        editData(data) {
            this.isEditData = true;
            this.id = data.row.id;
            console.log(data)
            axios.get("employee/edit/" + this.id).then((response) => {
                this.company_id = data.row.company_id;
                this.getDepartmentsByCompany(this.company_id);
                this.department_id = data.row.department_id;
                this.first_name = data.row.first_name;
                this.last_name = data.row.last_name;
                this.email = data.row.email;
                this.phone_number = data.row.phone_number;
                this.job_title = data.row.job_title;
                this.hire_date = data.row.hire_date;
            });
            $("#create-employee").modal("show");
        },
        updateData() {
            axios
                .put("/employee/update/" + this.id, {
                    department_id: this.department_id,
                    company_id: this.company_id, 
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    phone_number: this.phone_number,
                    job_title: this.job_title,
                    hire_date: this.hire_date,
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
        destroyData(data) {
            if (confirm("Are you sure you want to delete this data?")) {
                axios
                    .get("employee/destroy/" + data.row.id)
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
        console.log(this.companies);
    },
};
</script>
