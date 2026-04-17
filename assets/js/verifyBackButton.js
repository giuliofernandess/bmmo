(() => {
	const backButton = document.getElementById('safe-back-button');
	if (!backButton) {
		return;
	}

	const fallbackUrl = typeof window.fallbackPage === 'string' && window.fallbackPage.trim() !== ''
		? window.fallbackPage
		: '/';

	const isUnsafeUrl = (url) => {
		try {
			const parsedUrl = new URL(url, window.location.origin);
			return parsedUrl.pathname.includes('/actions/') || parsedUrl.search !== '';
		} catch (error) {
			return true;
		}
	};

	const goToSafeDestination = () => {
		const previousUrl = document.referrer;

		if (previousUrl && !isUnsafeUrl(previousUrl)) {
			window.location.href = previousUrl;
			return;
		}

		window.location.href = fallbackUrl;
	};

	backButton.addEventListener('click', (event) => {
		event.preventDefault();
		goToSafeDestination();
	});
})();
