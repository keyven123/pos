<template>
  <div class="container-fluid">
    <div class="row no-gutter">
        <!-- The left half -->
        <div class="col-md-6 col-lg-6 col-xl-6 d-md-flex">
            <div class="header-left">
                <p class="text-white m-0 queue-text-header">Preparing...</p>
            </div>
            <div class="container ">
                <div class="flex-container row padding-queue">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-6" v-for="(queue, index) in preparing" :key="index">
                            <div class="flex-item">
                                <p class="queue-text" style="color: #005cb9"> {{refNo(queue)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End -->
        </div>
        <!-- The right half -->
        <div class="col-md-6 col-lg-6 col-xl-6 bg-white">
            <div class="login py-2">
                <!-- Demo content-->
                <div class="header-right">
                    <p class="text-white m-0 queue-text-header">Please Collect...</p>
                </div>
                <div class="container ">
                    <div class="flex-container row padding-queue">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-xl-6" v-for="(queue, index) in collecting" :key="index">
                                <div class="flex-item">
                                    <p class="queue-text" style="color: green"> {{refNo(queue)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End -->
            </div>
        </div><!-- End -->
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
    name: "Queue",
    mounted() {
        this.getAllQueues()
        setInterval(() => this.getAllQueues(), 5000)
    },
    data() {
        return {
            queues: [],
            preparing: [],
            collecting: [],
            filter: {}
        }
    },
    methods: {
        getAllQueues() {
            axios.get(`api/getOrders`, {
                params: {
                    itemsPerPage: 100
                    }
            })
            .then(response => {
                this.queues = response.data.data
                this.preparing = this.queues.filter(element =>( element.status == 0))
                this.collecting = this.queues.filter(element =>( element.status == 1))
            })
        },
        refNo(item) {
            var ref = item.ref_no.slice(0 - 6)
            return ref
        }
    },
}
</script>

<style>
.queue-text-header {
    font-size: 80px;
}
.queue-text {
    font-size: 75px;
}
.padding-queue {
    padding-top: 120px;
}
@media only screen and (max-width: 768px) {
    .queue-text-header {
        font-size: 25px;
    }
    .queue-text {
        font-size: 20px;
    }
    .padding-queue {
        padding-top: 50px;
    }
  
}
</style>