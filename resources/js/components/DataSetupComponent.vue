<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-3 rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                                <span class="text-uppercase fw-bolder fs-5">Data Setup</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <b-tabs pills card vertical>
                                    <b-tab title="DOCUMENTS" active>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
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
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <b-form-input type="search" placeholder="Search Code / Document Name" aria-label="Search"
                                                                        v-model="search_main_docu"></b-form-input>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-mint w-100" @click="createMainDocuTrigger = true">
                                                                            <i class="fa-duotone fa-solid fa-square-plus fa-fw me-1"></i> Create Document
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <b-table :bordered=true :hover=true :items="searchMainDocuments" :fields="fields_documents" responsive show-empty
                                                                    :per-page="perPage" :current-page="currentPage" :busy="loading_table" id="tableMainDocu">
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
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.code }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(docu_name)="row">
                                                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.docu_name }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(created_at)="row">
                                                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.created_at }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(actions)="row">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-sm btn-primary" @click="editMainDocu(row.item)"><i class="fa-duotone fa-solid fa-pen-to-square fa-fw"></i></button>
                                                                            <button class="btn btn-sm btn-amaranth" @click="removeMainDocu(row.item)"><i class="fa-duotone fa-solid fa-trash fa-fw"></i></button>
                                                                        </div>
                                                                    </template>
                                                                </b-table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex justify-content-start align-items-center h-100">
                                                                <b-pagination v-model="currentPage" :total-rows="items_documents.length" :per-page="perPage"
                                                                    aria-controls="tableMainDocu" size="sm"></b-pagination>
                                                            </div>
                                                            <div class="col-md-6 d-flex justify-content-end align-items-center h-100">
                                                                <span class="text-uppercase">{{ items_documents.length }} item(s).</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="RANK">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
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
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <b-form-input type="search" placeholder="Search Code / Rank Name / Alias" aria-label="Search"
                                                                        v-model="search_main_docu"></b-form-input>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button class="btn btn-mint w-100" @click="createMainRankTrigger = true">
                                                                            <i class="fa-duotone fa-solid fa-square-plus fa-fw me-1"></i> Create Rank
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-12">
                                                                <b-table :bordered=true :hover=true :items="searchMainRanks" :fields="fields_ranks" responsive show-empty
                                                                    :per-page="perPage" :current-page="currentPage" :busy="loading_table" id="tableMainRank">
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
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.code }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(rank_name)="row">
                                                                        <div class="d-flex justify-content-start align-items-center h-100 my-2">
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.rank_name }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(alias)="row">
                                                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.alias }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(created_at)="row">
                                                                        <div class="d-flex justify-content-center align-items-center h-100 my-2">
                                                                            <span class="text-wrap" style="font-size: 13px;">{{row.item.created_at }}</span>
                                                                        </div>
                                                                    </template>
                                                                    <template #cell(actions)="row">
                                                                        <div class="text-center">
                                                                            <button class="btn btn-sm btn-primary" @click="editMainRanks(row.item)"><i class="fa-duotone fa-solid fa-pen-to-square fa-fw"></i></button>
                                                                            <button class="btn btn-sm btn-amaranth" @click="removeMainRanks(row.item)"><i class="fa-duotone fa-solid fa-trash fa-fw"></i></button>
                                                                        </div>
                                                                    </template>
                                                                </b-table>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 d-flex justify-content-start align-items-center h-100">
                                                                <b-pagination v-model="currentPage" :total-rows="items_ranks.length" :per-page="perPage"
                                                                    aria-controls="tableMainRank" size="sm"></b-pagination>
                                                            </div>
                                                            <div class="col-md-6 d-flex justify-content-end align-items-center h-100">
                                                                <span class="text-uppercase">{{ items_ranks.length }} item(s).</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="USERS">
                                        <b-card-text>Tab contents 3</b-card-text>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Main Document Modal -->
        <b-modal v-model="createMainDocuTrigger" centered size="lg" hide-header hide-header-close no-close-on-backdrop
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
                            <input type="text" class="form-control" id="document_code" v-model="main_docu_code">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <label for="document_name" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="document_name" v-model="main_docu_name">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="createMainDocu()">Submit</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Create Main Document Modal -->

        <!-- Edit Main Document Modal -->
        <b-modal v-model="editMainDocuTrigger" centered size="lg" hide-header hide-header-close no-close-on-backdrop
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
                            <input type="text" class="form-control" id="document_code" v-model="main_docu_code">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <label for="document_name" class="form-label">Document Name</label>
                        <input type="text" class="form-control" id="document_name" v-model="main_docu_name">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveMainDocu()">Save</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Edit Main Document Modal -->

        <!-- Create Main Ranks Modal -->
        <b-modal v-model="createMainRankTrigger" centered size="lg" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                        <span class="text-uppercase fw-bolder fs-5">Rank Details</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="rank_code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="rank_code" v-model="main_rank_code">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="rank_name" class="form-label">Rank Name</label>
                        <input type="text" class="form-control" id="rank_name" v-model="main_rank_name">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="rank_alias" class="form-label">Alias</label>
                        <input type="text" class="form-control" id="rank_alias" v-model="main_rank_alias">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="createMainRanks()">Submit</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Create Main Ranks Modal -->

        <!-- Edit Main Ranks Modal -->
        <b-modal v-model="editMainRankTrigger" centered size="lg" hide-header hide-header-close no-close-on-backdrop
            no-close-on-esc hide-footer>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start align-items-center h-100">
                        <span class="text-uppercase fw-bolder fs-5">Rank Details</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="">
                            <label for="rank_code" class="form-label">Code</label>
                            <input type="text" class="form-control" id="rank_code" v-model="main_rank_code">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="rank_name" class="form-label">Rank Name</label>
                        <input type="text" class="form-control" id="rank_name" v-model="main_rank_name">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <label for="rank_alias" class="form-label">Alias</label>
                        <input type="text" class="form-control" id="rank_alias" v-model="main_rank_alias">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                        <button type="button" class="btn btn-primary" @click="saveMainRanks()">Save</button>
                    </div>
                </div>
        </b-modal>
        <!-- End Edit Main Ranks Modal -->

        

    </div>
</template>

<script>
    import { min } from 'lodash';
import moment from 'moment';
    export default {
        props: ['user_data'],
        mounted() {
            this.getMainDocuments();
            this.getMainRanks();
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
                info: [],
                items_documents: [],
                fields_documents: [
                    { key: 'code', label: 'Code', thStyle:  { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'docu_name', label: 'Name', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'created_at', label: 'Date Created', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'actions', label: 'Actions', thStyle: { fontSize: '13px' }, thClass: 'text-center text-uppercase'},
                ],
                search_main_docu: null,
                items_ranks: [],
                fields_ranks: [
                    { key: 'code', label: 'Code', thStyle:  { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'rank_name', label: 'Name', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'alias', label: 'Alias', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'created_at', label: 'Date Created', thStyle: { fontSize: '13px' }, sortable: true, thClass: 'text-center text-uppercase'},
                    { key: 'actions', label: 'Actions', thStyle: { fontSize: '13px' }, thClass: 'text-center text-uppercase'},
                ],
                search_main_ranks: null,
                perPage: 5,
                currentPage: 1,
                loading_table: false,

                editMainDocuTrigger: false,
                createMainDocuTrigger: false,
                main_docu_code: null,
                main_docu_name: null,
                main_docu_id: null,

                editMainRankTrigger: false,
                createMainRankTrigger: false,
                main_rank_alias: null,
                main_rank_code: null,
                main_rank_name: null,
                main_rank_id: null,

                };
        },
        computed: {
            searchMainDocuments() {
            return this.search_main_docu
                ? this.items_documents.filter(item =>
                    item.code.toLowerCase().includes(this.search_main_docu.toLowerCase()) ||
                    item.docu_name.toLowerCase().includes(this.search_main_docu.toLowerCase()))
                : this.items_documents;
            },

            searchMainRanks() {
            return this.search_main_ranks
                ? this.items_ranks.filter(item =>
                    item.code.toLowerCase().includes(this.search_main_ranks.toLowerCase()) ||
                    item.rank_name.toLowerCase().includes(this.search_main_ranks.toLowerCase()) ||
                    item.alias.toLowerCase().includes(this.search_main_ranks.toLowerCase()))
                : this.items_ranks;
            },

        },
        methods: {
            getMainDocuments(){
                axios.get('/get/setup/docu')
                .then((response) => {
                    this.items_documents = response.data;
                    console.log(response.data);
                })
            },

            editMainDocu(data){
                this.editMainDocuTrigger = true;
                this.main_docu_code = data.code;
                this.main_docu_name = data.docu_name;
                this.main_docu_id = data.id;
            },

            saveMainDocu(){
                axios.post('/save/setup/docu/data', {
                    main_docu_code : this.main_docu_code,
                    main_docu_name : this.main_docu_name,
                    main_docu_id : this.main_docu_id
                }).then((response) => {
                    this.getMainDocuments();
                    this.closeModal();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Document Updated!',
                        html: 'Document details updated successfully.',
                    });
                })
            },

            createMainDocu(){
                axios.post('/create/setup/docu/data', {
                    main_docu_code : this.main_docu_code,
                    main_docu_name : this.main_docu_name,
                }).then((response) => {
                    this.getMainDocuments();
                    this.closeModal();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Document Created!',
                        html: 'Document details created successfully.',
                    });
                })
            },

            removeMainDocu(data){
                axios.post('/remove/setup/docu/data', {
                    main_docu_id : data.id
                }).then((response) => {
                    this.getMainDocuments();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Document Removed!',
                        html: 'Document details removed successfully.',
                    });
                })
            },

            getMainRanks(){
                axios.get('/get/setup/ranks')
                .then((response) => {
                    this.items_ranks = response.data;
                    console.log(response.data);
                })
            },

            editMainRanks(data){
                this.editMainRankTrigger = true;
                this.main_rank_code = data.code;
                this.main_rank_name = data.rank_name;
                this.main_rank_alias = data.alias;
                this.main_rank_id = data.id;
            },

            saveMainRanks(){
                axios.post('/save/setup/ranks/data', {
                    main_rank_code : this.main_rank_code,
                    main_rank_name : this.main_rank_name,
                    main_rank_alias : this.main_rank_alias,
                    main_rank_id : this.main_rank_id
                }).then((response) => {
                    this.getMainRanks();
                    this.closeModal();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Rank Updated!',
                        html: 'Rank details updated successfully.',
                    });
                })
            },

            createMainRanks(){
                axios.post('/create/setup/ranks/data', {
                    main_rank_code : this.main_rank_code,
                    main_rank_name : this.main_rank_name,
                    main_rank_alias : this.main_rank_alias,
                }).then((response) => {
                    this.getMainRanks();
                    this.closeModal();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Rank Created!',
                        html: 'Rank details created successfully.',
                    });
                })
            },

            removeMainRanks(data){
                axios.post('/remove/setup/ranks/data', {
                    main_rank_id : data.id
                }).then((response) => {
                    this.getMainRanks();
                    this.Toast.fire({
                        icon: 'success',
                        title: 'Rank Removed!',
                        html: 'Rank details removed successfully.',
                    });
                })
            },

            closeModal(){
                this.editMainDocuTrigger = false;
                this.createMainDocuTrigger = false;
                this.main_docu_code = null;
                this.main_docu_name = null;
                this.main_docu_id = null;

                this.editMainRankTrigger = false;
                this.createMainRankTrigger = false;
                this.main_rank_code = null;
                this.main_rank_name = null;
                this.main_rank_alias = null;
                this.main_rank_id = null;
            }
            
        },
    }
</script>
