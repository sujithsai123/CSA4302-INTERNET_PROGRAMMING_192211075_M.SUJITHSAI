document.addEventListener('DOMContentLoaded', function() {
    fetch('get_rooms.php')
        .then(response => response.json())
        .then(data => {
            const roomsDiv = document.getElementById('rooms');
            data.forEach(room => {
                const roomDiv = document.createElement('div');
                roomDiv.classList.add('room');
                roomDiv.innerHTML = `
                    <h2>${room.hotel_name} - Room ${room.room_number}</h2>
                    <p>Location: ${room.location}</p>
                    <p>Type: ${room.room_type}</p>
                    <p>Price: $${room.price}</p>
                    <button onclick="bookRoom(${room.id})">Book Now</button>
                `;
                roomsDiv.appendChild(roomDiv);
            });
        });
});

function bookRoom(roomId) {
    window.location.href = `book_room.php?room_id=${roomId}`;
}
