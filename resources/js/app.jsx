import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import axios from 'axios';

function BookCards() {
  const [books, setBooks] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);

  // Fungsi untuk mengambil data buku berdasarkan halaman
  const fetchBooks = (page = 1) => {
    setLoading(true);
    axios.get(`/api/books?page=${page}`)
      .then(response => {
        // Pastikan API mengembalikan data di key "data"
        setBooks(response.data.data);
        setCurrentPage(response.data.current_page);
        setLastPage(response.data.last_page);
      })
      .catch(error => {
        console.error("Error fetching books:", error);
      })
      .finally(() => {
        setLoading(false);
      });
  };

  // Ambil data buku ketika komponen pertama kali dimuat atau currentPage berubah
  useEffect(() => {
    fetchBooks(currentPage);
  }, [currentPage]);

  const handleNextPage = () => {
    if (currentPage < lastPage) {
      setCurrentPage(prev => prev + 1);
    }
  };

  const handlePrevPage = () => {
    if (currentPage > 1) {
      setCurrentPage(prev => prev - 1);
    }
  };

  return (
    <div className="container my-5">
      <h2 className="mb-4 text-center">Koleksi Buku</h2>

      {loading ? (
        <div className="text-center">
          <p>Loading...</p>
        </div>
      ) : (
        <>
          <div className="row">
            {books.map(book => (
              <div key={book.id} className="col-md-4 mb-4">
                <div className="card h-100">
                  <img 
                    src={book.cover ? book.cover : 'https://via.placeholder.com/200x300.png?text=No+Cover'} 
                    className="card-img-top" 
                    alt={book.judul} 
                    style={{ height: '300px', objectFit: 'cover' }} 
                  />
                  <div className="card-body">
                    <h5 className="card-title">{book.judul}</h5>
                    <p className="card-text">Penulis: {book.author ? book.author : 'Unknown'}</p>
                  </div>
                  <div className="card-footer">
                    <button 
                      className="btn btn-primary btn-block"
                      onClick={() => alert(`Booking buku: ${book.judul}`)}
                    >
                      Booking Sekarang
                    </button>
                  </div>
                </div>
              </div>
            ))}
          </div>

          <div className="d-flex justify-content-between">
            <button 
              className="btn btn-secondary" 
              onClick={handlePrevPage} 
              disabled={currentPage === 1}
            >
              Prev
            </button>
            <span>Halaman {currentPage} dari {lastPage}</span>
            <button 
              className="btn btn-secondary" 
              onClick={handleNextPage} 
              disabled={currentPage === lastPage}
            >
              Next
            </button>
          </div>
        </>
      )}
    </div>
  );
}

// Render komponen React ke elemen dengan id "landing-booking"
const container = document.getElementById('landing-booking');
if (container) {
  const root = ReactDOM.createRoot(container);
  root.render(<BookCards />);
}

export default BookCards;