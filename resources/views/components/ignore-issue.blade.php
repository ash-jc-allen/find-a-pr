@props(['issueUrl'])
<div x-data="{
        ignoreModalOpen: false,
        addIgnoredUrl(issueUrl){
            let ignoredUrls = JSON.parse(localStorage.getItem('ignoreUrl')) ?? [];
            ignoredUrls.push(issueUrl);
            localStorage.setItem('ignoreUrl', JSON.stringify(ignoredUrls));

            getIgnoredUrls();
        }
     }"
>
    <button
        @click="ignoreModalOpen = ! ignoreModalOpen"
        class="flex-1 px-3 py-2 ml-1 font-bold text-gray-400 transition-all duration-150 ease-linear border rounded-md outline-none hover:bg-gray-100 dark:border-slate-600 dark:hover:bg-slate-600 focus:outline-none"
        type="button"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
             stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        </svg>
    </button>

    <div x-show="ignoreModalOpen" class="relative z-10" aria-labelledby="modal-title"
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex items-end justify-center min-h-full p-4 text-center sm:items-center sm:p-0">
                <div
                    x-on:click.away="ignoreModalOpen = false"
                    class="relative overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-slate-800 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-700 dark:text-white">
                                    Ignore Issue
                                </h3>
                                <div class="mt-2">
                                    <p class="text-gray-600 text-md dark:text-stone-200">
                                        Are you sure you want to ignore the issue?
                                    </p>
                                    <p class="text-gray-600 text-md dark:text-stone-200">
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-slate-900 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            @click="
                                addIgnoredUrl('{{$issueUrl}}');
                                ignoreModalOpen = false;
                            "
                            type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Ignore
                        </button>
                        <button
                            @click="ignoreModalOpen = false"
                            type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:border-gray-400 dark:bg-slate-800 dark:text-stone-200 hover:bg-gray-50 dark:hover:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
