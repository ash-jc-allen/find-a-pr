<div class="flex flex-col sm:flex-row gap-2 justify-between item-center">
    <a href="/">
        <img class="w-48" src="{{ mix('/images/findapr.svg') }}" alt="findapr.io logo">
    </a>

    <div class="flex space-x-3 items-center">
        <button type="button"
                x-show="isDark"
                @click="toggleDarkMode(false)"
                class="flex justify-center items-center px-4 py-1.5 border border-transparent font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
            ☀️
        </button>

        <button type="button"
                x-show="!isDark"
                @click="toggleDarkMode(true)"
                class="flex justify-center items-center px-4 py-1.5 border border-transparent font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
        >
            🌙
        </button>

        <a href="https://github.com/ash-jc-allen/find-a-pr"
           class="flex justify-center items-center px-5 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            <img src="{{ mix('/images/github-logo.png') }}" class="w-6 pr-2 inline" alt="View on GitHub" />
            View on GitHub
        </a>
    </div>

</div>
