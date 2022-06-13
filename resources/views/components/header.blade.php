<div class="flex flex-col sm:flex-row gap-2 justify-between item-center">
    <a href="/">
        <img class="w-48 dark:hidden" src="{{ mix('/images/findapr.svg') }}" alt="findapr.io logo - light mode">
        <img class="w-48 hidden dark:block" src="{{ mix('/images/findapr-white.svg') }}" alt="findapr.io logo - dark mode">
    </a>

    <div class="flex space-x-3 items-center">
        <a href="https://docs.findapr.io"
           target="_blank"
           rel="noreferrer noopener"
           class="underline font-medium mr-3 text-gray-600 hover:text-green-600 transition ease-out dark:text-gray-100 dark:hover:text-green-600"
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
           class="flex justify-center items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-gray-900 transition ease-out">
            <img src="{{ mix('/images/github-logo.png') }}" class="inline w-5 md:pr-2 md:w-6" alt="View on GitHub" />
            <span class="hidden md:inline">View on GitHub</span>
        </a>
    </div>

</div>
