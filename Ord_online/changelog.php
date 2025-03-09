<!DOCTYPE html>
<html>
<head>
    <title>Endringslogg - Ord på Nett</title>
    <link rel="stylesheet" href="texteditor.scss">
</head>
<body>
    <h1>Endringslogg</h1>
    <div id="changelog"></div>

    <script>
        async function displayChangelog() {
            const changelogDiv = document.getElementById('changelog');
            const owner = 'isakbh';
            const repo = 'nettside'; // Lowercase as per your GitHub repo name
            const path = 'Ord_online'; // Just the folder name
            const apiUrl = `https://api.github.com/repos/${owner}/${repo}/commits?path=${path}`;

            try {
                const response = await fetch(apiUrl, {
                    headers: {
                        'Accept': 'application/vnd.github.v3+json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const commits = await response.json();

                if (commits.length === 0) {
                    changelogDiv.innerHTML = 'Ingen endringer funnet.';
                    return;
                }

                commits
                    .filter(commit => {
                        // You can add additional filtering here if needed
                        return true;
                    })
                    .forEach(commit => {
                        const commitElement = document.createElement('div');
                        commitElement.className = 'commit';
                        commitElement.innerHTML = `
                            <div class="commit-date">
                                ${new Date(commit.commit.author.date).toLocaleString('no-NO')}
                            </div>
                            <div class="commit-message">
                                ${commit.commit.message}
                            </div>
                            <div class="commit-author">
                                av ${commit.commit.author.name}
                            </div>
                            <a href="${commit.html_url}" target="_blank">Se på GitHub</a>
                        `;
                        changelogDiv.appendChild(commitElement);
                    });
            } catch (error) {
                console.error('Error:', error);
                changelogDiv.innerHTML = `Kunne ikke laste endringsloggen: ${error.message}`;
            }
        }

        displayChangelog();
    </script>
</body>
</html>
