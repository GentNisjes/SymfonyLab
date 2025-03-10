document.addEventListener("DOMContentLoaded", function () {
    console.log("JS loaded"); // ✅ Debug: Check if script runs



    const books = document.querySelectorAll(".book-item");
    if (books.length === 0) {
        console.log("No books found!"); // ✅ Debug: Check if elements exist
    }

    books.forEach(book => {
        book.addEventListener("click", showInfo);
    });

    const container = document.querySelector("#info-container");

    function showInfo(event) {
        const isbn = this.getAttribute("data-isbn").trim(); // ✅ Correct attribute access
        console.log("Clicked ISBN:", isbn); // ✅ Debug: See if click is detected

        if (!isbn) {
            container.innerHTML = `<p>No ISBN found for this book.</p>`;
            return;
        }

        const url = `https://openlibrary.org/isbn/${isbn}.json`;
        console.log("Fetching:", url); // ✅ Debug: Check fetch URL

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Book not found for ISBN: ${isbn}`);
                }
                return response.json();
            })
            .then(result => {
                processResult(result);
            })
            .catch(error => {
                console.log(`Fetch error: ${error.message}`);
                container.innerHTML = `<p>Book not found for ISBN: ${isbn}</p>`;
            });
    }

    function processResult(result) {
        const publishers = result.publishers ? result.publishers.join(", ") : "Unknown Publisher";
        const title = result.title || "Unknown Title";
        const publishDate = result.publish_date || "Unknown Date";
        const pageCount = result.number_of_pages ? `${result.number_of_pages} pages` : "Page count not available";

        container.innerHTML = `
            <p><strong>Title:</strong> ${title}</p>
            <p><strong>Publishers:</strong> ${publishers}</p>
            <p><strong>Published Date:</strong> ${publishDate}</p>
            <p><strong>Pages:</strong> ${pageCount}</p>
        `;
    }
});
