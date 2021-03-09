<template></template>

<script>
    export default {
        props: ['alert'],
        data() {
            return {
                parsedAlert: JSON.parse(this.alert),
            }
        },
        mounted() {
            sweetAlert({
                title: this.parsedAlert.header ? this.parsedAlert.header : "Error",
                text: this.parsedAlert.body ? this.parsedAlert.body : "Unknown error occurred!",
                icon: this.parsedAlert.status ? this.parsedAlert.status : "error",
                timer: this.parsedAlert.timer ? this.parsedAlert.timer : 2500,
                buttons: false
            });
        }
    }
</script>
