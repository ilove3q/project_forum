<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a id="navbarDropdownNotification" href="#" class="nav-link dropdown-toggle" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <span class="caret"> <i class="far fa-bell"></i> </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotification"
             v-for="notification in notifications"
        >
            <a class="dropdown-item"
               :href="notification.data.link"
               v-text="notification.data.message"
               @click="markAsRead(notification)"
            ></a>
        </div>
    </li>
</template>

<script>
export default {
    name: "UserNotifications",
    data() {
        return {
            notifications: false,
        }
    },
    created() {
        axios.get(`/profiles/${window.App.user.name}/notifications`)
            .then(response => this.notifications = response.data);
    },
    methods: {
        markAsRead(notification) {
            axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
        }
    },
}
</script>

<style scoped>

</style>
