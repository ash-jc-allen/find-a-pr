<div class="flex flex-col justify-between gap-2 sm:flex-row item-center">
    <a href="/">
        <img class="w-48 dark:hidden" src="{{ mix('/images/findapr.svg') }}" alt="findapr.io logo - light mode">
        <img class="hidden w-48 dark:block" src="{{ mix('/images/findapr-white.svg') }}" alt="findapr.io logo - dark mode">
    </a>

    <div class="flex items-center space-x-3">
        <a href="https://docs.findapr.io"
           target="_blank"
           rel="noreferrer noopener"
           class="mr-3 font-medium text-gray-600 underline transition ease-out hover:text-green-600 dark:text-gray-100 dark:hover:text-green-600"
        >
            Documentation
        </a>

        <button type="button"
                @click="toggleDarkMode(! isDark)"
                x-text="darkModeIcon()"
                class="flex justify-center items-center px-4 py-1.5 border border-transparent font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out"
        >
        </button>

        <a href="https://github.com/ash-jc-allen/find-a-pr"
           class="flex items-center justify-center px-5 py-2 text-sm font-medium text-white transition ease-out bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900">
            <img src="{{ mix('/images/github-logo.png') }}" class="inline w-5 md:w-6 md:pr-2" alt="View on GitHub" />
            <span class="hidden md:inline">View on GitHub</span>
        </a>
    </div>

</div>
