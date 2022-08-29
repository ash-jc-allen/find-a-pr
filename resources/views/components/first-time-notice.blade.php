<div x-data="{ show: @entangle('shouldDisplayFirstTimeNotice') }" x-show="show" class="border bg-green-200 dark:border-slate-600 p-4 sm:py-5 sm:px-8 my-4 rounded-lg shadow dark:bg-green-400 dark:text-gray-700">
    <div class="flex flex-col sm:flex-row justify-start sm:justify-between items-start gap-2">
        <div class="w-full md:w-3/4">
            <p class="text-xl font-bold inline-block">First time here? 👋</p>
        </div>

        <button type="button"
                x-on:click="show = false"
                class="flex justify-center items-center px-4 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:hover:bg-green-600 dark:focus:ring-offset-green-400 transition ease-out"
        >Okay, got it!</button>
    </div>

    <p class="my-4">
        Welcome to <span class="font-bold">Find a PR</span>.<br><br>
        Find a PR is an open-source site that is built to help developers find projects so that they can submit their very first pull request.<br><br>
        <span class="font-bold">If you're a contributor</span> looking to find a project to contribute to, feel free to browse through the list below.<br><br>
        <span class="font-bold">If you're a maintainer</span> looking to list your project on Find a PR, you can read how to do this in the <a href="https://docs.findapr.io" class="underline" target="_blank" rel="noreferrer noopener">documentation</a>.
    </p>
</div>
