<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-3 rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-6 d-flex justify-content-start align-items-center h-100">
                                <span class="text-uppercase fw-bolder fs-5">Documents Submitted</span>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 text-end">
                                <!-- <span class="text-uppercase fw-bolder fs-5">Crew List</span> -->
                                 <button class="btn btn-mint btn-sm" @click="uploadDocumentModalTrigger = true">
                                    <i class="fa-duotone fa-solid fa-upload fa-fw me-1"></i> Upload Document
                                 </button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2 pe-1">
                                        <b-form-select v-model="perPage" :options="$page_options" required class="form-control"></b-form-select>
                                    </div>
                                    <div class="col-md-10 d-flex justify-content-start align-items-center ps-1">
                                        <span class="text-dark">entries per page</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b-form-input type="search" placeholder="Search Firstname / Lastname / Rank" aria-label="Search"
                                v-model="search"></b-form-input>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <b-table :bordered=true :hover=true :items="searchCrewDocu" :fields="fields" responsive show-empty
                                    :per-page="perPage" :current-page="currentPage" :busy="loading_table" id="tableCrewDocu">
                                    <template #empty="scope">
                                        <div class="container-fluid bg-light p-3 text-center border border-lg rounded">
                                            <h5 class="text-muted pt-2 pb-1">No Records Found.</h5>
                                        </div>
                                    </template>
                                    <template #table-busy>
                                        <div class="container-fluid bg-light p-3 text-center border border-lg rounded">
                                            <i class="fa-duotone fa-spinner fa-spin-pulse fa-lg"></i>
                                            <h5 class="text-muted pt-2 pb-1">Loading...</h5>
                                        </div>
                                    </template>
                                    <template #cell(code)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span v-if="moment(row.item.expiry_date).subtract(7, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-amaranth" style="font-size: 13px;">{{row.item.code }}</span>
                                            <span v-else-if="moment(row.item.expiry_date).subtract(30, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-warning" style="font-size: 13px;">{{row.item.code }}</span>
                                            <span v-else-if="moment(row.item.expiry_date).subtract(90, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-orange" style="font-size: 13px;">{{row.item.code }}</span>
                                            <span v-else  class="text-wrap" style="font-size: 13px;">{{row.item.code }}</span>
                                        </div>
                                    </template>
                                    <template #cell(document_name)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.document_name }}</span>
                                        </div>
                                    </template>
                                    <template #cell(document_no)="row">
                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.document_no }}</span>
                                        </div>
                                    </template>
                                    <template #cell(issued_date)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.issued_date }}</span>
                                        </div>
                                    </template>
                                    <template #cell(expiry_date)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span v-if="moment(row.item.expiry_date).subtract(7, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-amaranth" style="font-size: 13px;">{{row.item.expiry_date }}</span>
                                            <span v-else-if="moment(row.item.expiry_date).subtract(30, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-warning" style="font-size: 13px;">{{row.item.expiry_date }}</span>
                                            <span v-else-if="moment(row.item.expiry_date).subtract(90, 'days').format('YYYY-MM-DD') <= moment().format('YYYY-MM-DD')"  class="text-wrap badge bg-orange" style="font-size: 13px;">{{row.item.expiry_date }}</span>
                                            <span v-else  class="text-wrap" style="font-size: 13px;">{{row.item.expiry_date }}</span>
                                        </div>
                                    </template>
                                    <template #cell(person_in_charge)="row">
                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.person_in_charge }}</span>
                                        </div>
                                    </template>
                                    <template #cell(actions)="row">
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-primary" @click="viewCrewModal(row.item)"><i class="fa-duotone fa-solid fa-file-magnifying-glass fa-fw"></i></button>
                                            <button class="btn btn-sm btn-amaranth" @click="removeCrewDocu(row.item)"><i class="fa-duotone fa-solid fa-trash fa-fw"></i></button>
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start align-items-center h-100">
                                <b-pagination v-model="currentPage" :total-rows="items.length" :per-page="perPage"
                                    aria-controls="tableCrewDocu" size="sm"></b-pagination>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center h-100">
                                <span class="text-uppercase">{{ items.length }} item(s).</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Document Modal -->
        <b-modal v-model="uploadDocumentModalTrigger" centered size="xl" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                        <span class="text-uppercase fw-bolder fs-5">Document Details</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="document_code" class="form-label">Code</label>
                            <select class="form-select" v-model="document_code" @change="setDocuName()" id="document_code">
                                <option selected value="null" disabled>-- Please select code --</option>
                                <option v-for="(data, index) in documents_list" :key="index">{{ data.code }}</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="rank" placeholder="(optional)" v-model="rank"> -->
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <label for="document_name" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="document_name" placeholder="" v-model="document_name" readonly>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="document_no" class="form-label">Document No.</label>
                        <input type="text" class="form-control" id="document_no" placeholder="" v-model="document_no">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <label for="document_file" class="form-label">File</label>
                        <b-form-file v-model="document_file" id="document_file" class="form-control" placeholder="" plain accept="application/pdf"></b-form-file>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="birthdate" class="form-label">Issued Date</label>
                            <input type="date" class="form-control" id="birthdate" v-model="issued_date" :max="today">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="birthdate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="birthdate" v-model="expiry_date" :min="issued_date">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-12 col-lg-12 text-end">
                        <span class="text-primary fw-bolder fst-italic text-uppercase">
                            Uploader: {{ this.info.name }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitCrewDocument()">Submit</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Upload Document Modal -->

        <!-- View Document Modal -->
        <b-modal v-model="viewDocumentModalTrigger" centered size="xl" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                        <span class="text-uppercase fw-bolder fs-5">Document Details</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="document_code" class="form-label">Code</label>
                            <select class="form-select" v-model="document_code" @change="setDocuName()" id="document_code">
                                <option selected value="null" disabled>-- Please select code --</option>
                                <option v-for="(data, index) in documents_list" :key="index">{{ data.code }}</option>
                            </select>
                            <!-- <input type="text" class="form-control" id="rank" placeholder="(optional)" v-model="rank"> -->
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <label for="document_name" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="document_name" placeholder="" v-model="document_name" readonly>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="document_no" class="form-label">Document No.</label>
                        <input type="text" class="form-control" id="document_no" placeholder="" v-model="document_no">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <label for="document_file" class="form-label">File</label>
                        <b-form-file v-model="document_file" id="document_file" class="form-control" placeholder="" plain accept="application/pdf"></b-form-file>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="birthdate" class="form-label">Issued Date</label>
                            <input type="date" class="form-control" id="birthdate" v-model="issued_date" :max="today">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="">
                            <label for="birthdate" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="birthdate" v-model="expiry_date" :min="issued_date">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-12 col-lg-12 text-end">
                        <span class="text-primary fw-bolder fst-italic text-uppercase">
                            Uploader: {{ this.info.name }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <!-- <button type="button" class="btn btn-primary" @click="submitCrewDocument()">Submit</button> -->
                    </div>
                </div>
        </b-modal>
        <!-- End View Document Modal -->

        

    </div>
</template>

<script>
    import { min } from 'lodash';
import moment from 'moment';
    export default {
        props: ['crew_id','user_data'],
        mounted() {
            this.getCrewDocuments();
            this.getCrewDocumentsCode();
            this.info = JSON.parse(this.user_data);
        },
        data() {
            return {
                moment: moment,
                Toast : this.$swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', this.$swal.stopTimer)
                        toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                    }
                }),
                
                today: moment().format('YYYY-MM-DD'),
                // today: new Date().toISOString().split('T')[0],
                document_code: null,
                documents_list: [],
                document_name: null,
                document_no: null,
                issued_date: null,
                expiry_date: null,
                uploaded_by: null,
                document_file: null,
                info: [],
                items: [],
                fields: [
                    { key: 'code', label: 'Code', thStyle:  { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'document_name', label: 'Name', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'document_no', label: 'Document No.', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'issued_date', label: 'Issued Date', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'expiry_date', label: 'Expiry Date', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'person_in_charge', label: 'Uploaded By', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'actions', label: 'Actions', thStyle: { fontSize: '13px' }, thClass: 'text-center text-uppercase'},
                ],
                search: null,
                perPage: 5,
                currentPage: 1,
                loading_table: false,

                viewCrewModalTrigger: false,
                uploadDocumentModalTrigger: false,
                };
        },
        computed: {
            searchCrewDocu() {
            return this.search
                ? this.items.filter(item =>
                    item.code.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.document_no.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.document_name.toLowerCase().includes(this.search.toLowerCase()) ||
                    item.person_in_charge.toLowerCase().includes(this.search.toLowerCase()))
                : this.items;
            // item.date.toLowerCase().includes(this.search.toLowerCase()))
        },

        },
        methods: {
            getCrewDocuments(){
                axios.post('/get/crew/docu/list', {
                    crew_id: this.crew_id,
                }).then((response) => {
                    this.items = response.data;
                })
            },

            getCrewDocumentsCode(){
                axios.get('/get/crew/docu/codes')
                .then((response) => {
                    this.documents_list = response.data;
                    console.log(response.data);
                })
            },

            getInput(){
                console.log(this.document_file)
            },
            
            setDocuName() {
                if (this.document_code) {
                    const selectedDocument = this.documents_list.find(doc => doc.code === this.document_code);
                    this.document_name = selectedDocument.docu_name;
                }
            },

            submitCrewDocument(){
                if(!this.document_code){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Please select a document code!"
                    });
                }
                else if(!this.document_no){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Document no. is required!"
                    });
                }
                else if(!this.document_file){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Document is required!"
                    });
                }
                else if(this.document_file.type !== 'application/pdf'){
                    this.Toast.fire({
                        icon: "error",
                        title: "Invalid Format!",
                        html: "Only pdf is allowed!"
                    });
                }
                else if(!this.issued_date){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Issued date is required!"
                    });
                }
                else if(!this.expiry_date){
                    this.Toast.fire({
                        icon: "error",
                        title: "Fields Required",
                        html: "Expiry date is required!"
                    });
                }
                else{
                    this.$swal.fire({
                        title: 'Upload Crew Document',
                        html: "Are you sure you want to upload this document to the selected crew?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3cba92',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Proceed'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form_data = new FormData();
                            form_data.append('document_file', this.document_file);
                            form_data.append('document_code', this.document_code);
                            form_data.append('document_name', this.document_name);
                            form_data.append('document_no', this.document_no);
                            form_data.append('issued_date', this.issued_date);
                            form_data.append('expiry_date', this.expiry_date);
                            form_data.append('crew_id', this.crew_id);

                            axios.post('/insert/crew/docu/data',form_data)
                            .then((response)=>{
                                this.getCrewDocuments();
                                this.closeModal();
                                this.Toast.fire({
                                    icon: 'success',
                                    title: 'Crew Document Uploaded!',
                                    html: 'Crew document uploaded successfully.',
                                });
                            })
                        }
                    })
                }
            },

            removeCrewDocu(data){
                this.$swal.fire({
                    title: 'Remove Crew Document',
                    html: "Are you sure you want to remove this document from the list?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3cba92',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post('/remove/crew/docu/data', {
                            id: data.id,
                        }).then((response) => {
                            this.getCrewDocuments();
                            this.Toast.fire({
                                icon: 'success',
                                title: 'Crew Document Removed!',
                                html: 'Crew document removed successfully.',
                            });
                        })
                    }
                })
                
            },

            viewCrewModal(data){
                this.viewCrewModalTrigger = true;
                this.first_name = data.first_name;
                this.last_name = data.last_name;
                this.middle_name = data.middle_name;
                this.address = data.address;
                this.email = data.email;
                this.birthdate = data.birthdate;
                this.age = data.age;
                this.rank = data.rank;
                this.height = data.height;
                this.weight = data.weight;
                this.calculateBMI();
                console.log(data);
            },

            closeModal(){
                this.uploadDocumentModalTrigger = false;
                this.viewCrewModalTrigger = false;

                this.document_code = null;
                this.document_name = null;
                this.document_no = null;
                this.issued_date = null;
                this.expiry_date = null;
                this.document_file = null;
            },
        },
    }
</script>
