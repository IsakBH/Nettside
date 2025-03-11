async function displayChangelog() {
    const changelogDiv = document.getElementById('changelog');
    const owner = 'isakbh';
    const repo = 'nettside';
    const path = 'Ord_online';
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
            changelogDiv.innerHTML = 'Ingen endringer funnet :( Si at Isak skal locke inn';
            return;
        }

        commits
            .filter(commit => {
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
