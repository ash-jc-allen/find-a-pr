<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                content: e.detail.content,
                type: e.detail.type || 'info'
            })
        },
        remove(notification) {
            this.notifications = this.notifications.filter(i => i.id !== notification.id)
        }
    }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 pr-4 pb-4 max-w-xs w-full flex flex-col space-y-4 sm:justify-start z-30"
    role="status"
    aria-live="polite">

    <!-- Notification -->
    <template x-for="notification in notifications" :key="notification.id">
        <div
            x-data="{
                show: false,
                init() {
                    this.$nextTick(() => this.show = true);

                    setTimeout(() => this.transitionOut(), 2000);
                },
                transitionOut() {
                    this.show = false;

                    setTimeout(() => this.remove(this.notification), 500);
                }
            }"
            x-show="show"
            x-transition.duration.500ms
            class="flex items-end px-4 py-1 pointer-events-none sm:px-6 sm:items-start">
            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
                <div class="max-w-sm w-full bg-white dark:bg-slate-900 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-center">

                            <!-- Icon -->
                            <svg x-show="notification.type === 'success'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <svg x-show="notification.type === 'info'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <svg x-show="notification.type === 'error'" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <!-- Text -->
                            <div class="w-0 flex-1 flex justify-between ml-2 mr-4">
                                <p class="w-0 flex-1 text-sm font-medium" x-text="notification.content"></p>
                            </div>

                            <!-- Remove button -->
                            <div class="flex-shrink-0 flex">
                                <button type="button" class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" @click="transitionOut()">
                                    <span class="sr-only">Close notification</span>
                                    <svg aria-hidden="true" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
