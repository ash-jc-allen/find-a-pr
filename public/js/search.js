const searchIcon = document.getElementById('search-icon');
const searchInput = document.querySelector('[data-search]');
const issues = getEveryIssue();

searchIcon.addEventListener('click', function () {
    const searchDiv = document.getElementById('search-div');
    searchDiv.classList.toggle('hidden');
});

searchInput.addEventListener('input', function (event) {
    const value = event.target.value.toLowerCase();
    let counter = 0;
    issues.forEach(issue => {
        const isVisible =
            issue.title.toLowerCase().includes(value) ||
            issue.repoName.toLowerCase().includes(value) ||
            issue.repoMaintainer.toLowerCase().includes(value);
        if (!issue.element.classList.toggle('hidden', !isVisible)) {
            counter++
        }
        document.querySelector('[data-issue-counter]').textContent = counter.toString();
    });
});

function getEveryIssue() {
    const issueList = document.querySelectorAll('[data-issue]');
    return Array.from(issueList).map(issue => {
        const title = issue.querySelector('[data-issue-name]').textContent;
        const repoName = issue.querySelector('[data-repo-name]').textContent;
        const repoMaintainer = issue.querySelector('[data-repo-maintainer]').textContent;
        return {title: title, repoName: repoName, repoMaintainer: repoMaintainer, element: issue};
    });
}

