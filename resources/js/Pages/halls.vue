<template>
    <app-layout :event="event" :form="form" :data="data">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Enrolment - (Laravel 8 Inertia JS CRUD with Jetstream & Tailwind CSS )
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if=" Object.keys($page.props.errors ).length > 0 ">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.errors }}</p>
                        </div>
                      </div>
                    </div>

                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>

                    <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3" v-if="$page.props.userrole !== 'student'">Create New hall</button>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Course</th>
                                <th class="px-4 py-2">Student</th>
                                <th class="px-4 py-2">Attachment</th>
                                <th class="px-4 py-2">First</th>
                                <th class="px-4 py-2">Mid</th>
                                <th class="px-4 py-2">Final</th>
                                <th class="px-4 py-2" v-if="$page.props.userrole !== 'student'">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data"  v-bind:key="row.id">
                                <td class="border px-4 py-2">{{ row.id }}</td>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">
                                    {{ courses[row.course_id] }}
                                    </td>
                                <td class="border px-4 py-2">
                                    {{ students[row.student_id]  }}
                                    </td>
                                <td class="border px-4 py-2">

<a v-if="row.attachment" :href="'storage/'+row.attachment" download  target="_blank">download file</a>

                                    </td>
                                <td class="border px-4 py-2">{{ row.first }}</td>
                                <td class="border px-4 py-2">{{ row.mid }}</td>
                                <td class="border px-4 py-2">{{ row.final }}</td>

                                <td class="border px-4 py-2"  v-if="$page.props.userrole !== 'student'">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.name">
                                      <div v-if="$page.props.errors.name" class="text-red-500">{{ $page.props.errors.name }}</div>
                                  </div>

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Course:</label>

  <select  v-model="form.course_id" @change="filter" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        <option :value="v" v-for="(k, v) in courses"  :key="k">{{ k }}  </option>
   </select>


                                      <div v-if="$page.props.errors.course_id" class="text-red-500">{{ $page.props.errors.course_id }}</div>
                                  </div>

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Student:</label>


  <select v-model="form.student_id" @change="filter" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
       <option :value="v" v-for="(k, v) in students"  :key="k">{{ k }}  </option>
   </select>


                                  </div>

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">first:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.first">
                                      <div v-if="$page.props.errors.first" class="text-red-500">{{ $page.props.errors.first }}</div>
                                  </div>

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">mid:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.mid">
                                      <div v-if="$page.props.errors.mid" class="text-red-500">{{ $page.props.errors.mid }}</div>
                                  </div>

                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">final:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.final">
                                      <div v-if="$page.props.errors.final" class="text-red-500">{{ $page.props.errors.final }}</div>
                                  </div>

                                  <div class="mb-4"  v-if="form.id">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">attachment:</label>
                                      <!-- <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter Name" v-model="form.email"> -->

    <input type="file" @input="form.attachment = $event.target.files[0]" />
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>

                                      <div v-if="$page.props.errors.attachment" class="text-red-500">{{ $page.props.errors.attachment }}</div>
                                  </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                                Save
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Update
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">

                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                          </div>
                          </form>

                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>

    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'
    export default {
        components: {
            AppLayout,
            Welcome,
            app ,
        },
        props: ['data', 'errors','userrole','courses','students'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                attachment:'',
                form: {
                    name: null,
                },
            }
        },
        methods: {
            filter() {
              var data = this.sort;
              console.log(data);
          } ,
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {

                this.form = {
                    name: null,
                    course_id: null,
                    student_id:null,
                    first:null,
                    final:null,
                    mid:null,
                    attachment:null,
                }
            },
            save: function (data) {
                this.$inertia.post('/halls', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/halls/' + data.id, data ,{forceFormData: true,} )
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/halls/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            upload: function (event) {
                this.attachment = event.target.files[0];
                alert(this.attachment) ;
            }
        }
    }
</script>
