// Favorites management using localStorage
function toggleFavorite(carId, carName) {
    let favorites = JSON.parse(localStorage.getItem('yourcars_favorites')) || [];
    const index = favorites.findIndex(fav => fav.id === carId);
    
    if (index > -1) {
        favorites.splice(index, 1);
        alert(carName + ' removed from your favorites.');
    } else {
        favorites.push({ id: carId, name: carName });
        alert(carName + ' added to your favorites!');
    }
    
    localStorage.setItem('yourcars_favorites', JSON.stringify(favorites));
}
