
import { useEffect, useState } from "react";

export default function App() {
    const [selectedFilm, setSelectedFilm] = useState(null);

    function handleFilmSelection(id) {
        setSelectedFilm(id);
    }

    return (
        <>
            {
                selectedFilm
                    ? <FilmPage selectedFilm={selectedFilm} onSelect={handleFilmSelection} />
                    : <Homepage onSelect={handleFilmSelection} />
            }
        </>
    );

}


function Homepage({ onSelect }) {
    const [topFilms, setTopFilms] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState("");

    useEffect(function() {

        async function getTopFilms() {

            try {
                setIsLoading(true);
                setError("");

                const result = await fetch('http://localhost/data/get-top-films');

                if (!result.ok) {
                    throw new Error("Error loading data.");
                }

                const data = await result.json();

                setTopFilms(data);
            } catch (error) {
                console.log(error);
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        getTopFilms();
    }, []);


    return (
        <>
            {isLoading && <Loading />}
            {error && <ErrorMsg message={error} />}
            {!isLoading && !error && (
                topFilms.map((film, idx) => (<TopFilm film={{ ...film, idx: idx }} key={film.id} onSelect={onSelect} />))
            )}
        </>
    );
}

function TopFilm({film, onSelect}) {

    return (
        <div className="row mb-5 pt-5 pb-5 bg-light">
            <div className={`col-md-6 mt-2 px-5 ${film.idx % 2 === 0 ? 'text-start order-2' : 'text-end order-1'}`}>
                <p className="display-4">{ film.name }</p>
                <p className="lead">{ (film.description.split(' ').slice(0, 32).join(' ')) + '...' }</p>
                <button className="btn btn-success" onClick={ () => onSelect(film.id) }>View</button>
            </div>
            <div className={`col-md-6 text-center ${film.idx % 2 === 0 ? 'order-1' : 'order-2'}`}>
                <img className="img-fluid img-thumbnail rounded-lg w-50" alt={ film.name } src={ film.image } />
            </div>
        </div>
    );
}

function FilmPage({ selectedFilm, onSelect }) {
    return (
        <>
            <FilmDetails selectedFilm={selectedFilm} onSelect={onSelect} />
            <RelatedContainer selectedFilm={selectedFilm} onSelect={onSelect} />
        </>
    );
}

function FilmDetails({ selectedFilm, onSelect }) {
    const [filmData, setFilmData] = useState({});
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState("");

    useEffect(function() {

        async function getFilmData(selectedFilm) {

            try {

                setIsLoading(true);
                setError("");

                const result = await fetch('http://localhost/data/get-film/' + selectedFilm, { mode: 'cors' });

                if (!result.ok) {
                    throw new Error("Error loading data");
                }

                const data = await result.json();

                setFilmData(data);

            } catch (error) {
                console.log(error);
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        getFilmData(selectedFilm);
    }, [selectedFilm]);

    return (
        <>
            {isLoading && <Loading />}
            {error && <ErrorMsg message={error} />}
            {!isLoading && !error && (
                <div className="row mb-5">
                    <div className="col-md-6 pt-5">
                        <h1 className="display-3">{filmData.name}</h1>
                        <p className="lead">{filmData.description}</p>
                        <dl className="row">
                            <dt className="col-sm-3">Year</dt>
                            <dd className="col-sm-9">{filmData.year}</dd>
                            <dt className="col-sm-3">Rating</dt>
                            <dd className="col-sm-9">{filmData.rating}</dd>
                            <dt className="col-sm-3">Gendre</dt>
                            <dd className="col-sm-9">{filmData.genre}</dd>
                        </dl>
                        <button className="btn btn-dark" onClick={ () => onSelect(null) }>To start</button>
                    </div>
                    <div className="col-md-6 text-center p-5">
                        <img className="img-fluid img-thumbnail rounded-lg" src={filmData.image} alt={filmData.name} />
                    </div>
                </div>
            )}
        </>
    );
}

function RelatedContainer({ selectedFilm, onSelect }) {
    const [relatedFilms, setRelatedFilms] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState("");

    useEffect(function() {

        async function getRelatedFilms(selectedFilm) {

            try {

                setIsLoading(true);
                setError("");

                const result = await fetch('http://localhost/data/get-related-films/' + selectedFilm, { mode: 'cors' });

                if (!result.ok) {
                    throw new Error("Error loading data");
                }

                const data = await result.json();

                setRelatedFilms(data);

            } catch (error) {
                console.log(error);
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        getRelatedFilms(selectedFilm);
    }, [selectedFilm]);

    return (
        <>
            {isLoading && <Loading />}
            {error && <ErrorMsg message={error} />}
            {!isLoading && !error && (
                <>
                    <div className="row mt-5">
                        <div className="col-md-12">
                            <h2 className="display-4">Similar movies</h2>
                        </div>
                    </div>
                    <div className="row mb-5">
                        {relatedFilms.map((film) => (<RelatedFilm film={film} key={film.id} onSelect={onSelect} />))}
                    </div>
                </>
            )}
        </>
    );
}

function RelatedFilm({ film, onSelect }) {
    return (
        <div className="col-md-4">
            <div className="card">
                <img className="card-img-top" src={film.image} alt={film.name} style={{ height: "620px" }} />
                <div className="card-body">
                    <h5 className="card-title">{film.name}</h5>
                    <button className="btn btn-success" onClick={ () => onSelect(film.id) }>View</button>
                </div>
            </div>
        </div>
    );
}


function Loading() {
    return (
        <div className="row mb-5 mt-5">
            <div className="text-center">
                <img src="./loading.gif" alt="Please wait!" className="mx-auto d-block" />
            </div>
        </div>
    );
}

function ErrorMsg({ message }) {
    return (
        <div className="alert alert-danger">
            <p>{message}</p>
            <p>Please reload page!</p>
        </div>
    );
}