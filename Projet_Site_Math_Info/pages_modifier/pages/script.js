// Exemple de mise à jour des statistiques avec JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Remplacez les valeurs ici avec celles récupérées depuis une API ou une base de données
    let stats = {
        studentCount: '5,000',
        graduatesCount: '4,000',
        programsCount: '50',
        successRate: '95%'
    };

    document.getElementById('studentCount').textContent = stats.studentCount;
    document.getElementById('graduatesCount').textContent = stats.graduatesCount;
    document.getElementById('programsCount').textContent = stats.programsCount;
    document.getElementById('successRate').textContent = stats.successRate;
});
