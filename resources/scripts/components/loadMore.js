// components/loadMore.js
import { loadMoreSearchResults } from '../api/ajax';

export const setupLoadMore = () => {
    const loadMoreButton = document.getElementById('load-more-button');
    const searchResultsContainer = document.getElementById('search-results-container');
    const spinner = document.getElementById('spinner');

    if (!loadMoreButton || !searchResultsContainer || !spinner) {
        return;
    }

    loadMoreButton.addEventListener('click', async () => {
        const currentPage = parseInt(loadMoreButton.getAttribute('data-current-page'), 10);
        const nextPage = currentPage + 1;

        loadMoreButton.classList.add('hidden');
        spinner.classList.remove('hidden');

        try {
            const data = await loadMoreSearchResults(nextPage);
            if (data && data.success && data.data) {
                data.data.search_results.forEach((result) => {
                    searchResultsContainer.insertAdjacentHTML('beforeend', createResultHTML(result));
                });

                if (nextPage >= data.data.pagination.total) {
                    loadMoreButton.remove();
                } else {
                    loadMoreButton.setAttribute('data-current-page', nextPage.toString());
                    loadMoreButton.classList.remove('hidden');
                }
            }
        } catch (error) {
            console.error('Error loading more results:', error);
        } finally {
            spinner.classList.add('hidden');
        }
    });
};

function createResultHTML(result) {
    const isLocked = result.is_locked;
    return `
        <div class="bg-base-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg relative">
            ${isLocked ? `
                <div class="absolute top-2 right-2 bg-base-100 rounded-full p-2 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            ` : ''}
            <a href="${result.link}" class="block">
                <div class="h-2 bg-cover bg-center" style="background-color: ${result.category_color || '#CCCCCC'};"></div>
            </a>
            <div class="p-4 py-6">
                <div class="text-sm mb-4">
                    ${result.categories.map((category) => `<span class="badge badge-outline">${category.name}</span>`).join('')}
                </div>
                <h3 class="text-xl font-semibold mb-4">
                    <a href="${result.link}" class="hover:underline">${result.title}</a>
                </h3>
                <p class="mt-2 text-xs text-gray-500 dark:text-neutral-500">Published on ${result.date}</p>
                ${isLocked ?
                    `<button class="inline-block bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed mt-4" title="You don't have permission to access this content">Locked</button>` :
                    `<a href="${result.link}" class="font-bold text-primary dark:text-primary-dark hover:underline transition duration-300 mt-3 block">Read More <svg class="inline w-3.5 h-3.5 ms-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg></a>`
                }
            </div>
        </div>
    `;
}