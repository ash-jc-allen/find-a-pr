<div class="flex flex-col sm:flex-row gap-2 justify-between item-center">
    <a href="/">
        <img class="w-48 dark:hidden" src="{{ asset('images/findapr.svg') }}" alt="findapr.io logo - light mode">
        <img class="w-48 hidden dark:block" src="{{ asset('images/findapr-white.svg') }}" alt="findapr.io logo - dark mode">
    </a>

    <div class="flex space-x-3 items-center">
        <a href="https://docs.findapr.io" target="_blank"
           class="flex justify-center items-center h-10 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out">
            <img src="{{ asset('images/docs-icon.svg') }}" class="inline w-5 md:pr-2 md:w-6 text-white" alt="View documentation" />
            <span class="hidden md:inline">Documentation</span>
        </a>

        <a href="https://github.com/ash-jc-allen/find-a-pr" target="_blank"
           class="flex justify-center items-center h-10 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out">
            <img src="{{ asset('images/github-logo.png') }}" class="inline w-5 md:pr-2 md:w-6" alt="View on GitHub" />
            <span class="hidden md:inline"><span class="hidden lg:inline">View on </span>GitHub</span>
        </a>

        <a href="https://twitter.com/findapr" target="_blank"
           class="flex justify-center items-center h-10 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out">
            <img src="{{ asset('images/twitter-logo.svg') }}" class="inline w-5 md:pr-2 md:w-6" alt="Follow on Twitter" />
            <span class="hidden md:inline"><span class="hidden lg:inline">Follow on </span>Twitter</span>
        </a>

        <div class="mx-6 border-gray-300 border-r h-6 mx-aut dark:border-slate-500"></div>

        <button type="button"
                @click="toggleDarkMode(! isDark)"
                x-text="darkModeIcon()"
                class="flex justify-center items-center h-10 px-4 py-1.5 border border-transparent font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out"
        >
        </button>
    </div>

</div>
