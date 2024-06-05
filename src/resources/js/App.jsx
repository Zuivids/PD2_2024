import { useEffect, useState } from "react";

export default function App(){

    const [selectedFilm, setSelectedFilm] = useState(null);

    function handleFilmSelection(id) {
        selectedFilm(id);
    }

    return (
        <>
            {
                selectedFilm
                ? <FilmPage selectedFilm={selectedFilm}/>
                : <Homepage onSelect={handleFilmSelection}/>
            }
        </>
        
    );

}

function Homepage({onSelect}){

    const [TopFilms, setTopFilms] = useState([]);

    useEffect(function() {

        async function getTopFilms(){

            try{
                
                const result = await fetch('http://localhost/data/get-top-films');

                if(!result.ok){
                    throw new Error("Error loading data");
                }

                const data = await result.json();

                setTopFilms(data);

            }catch(error){
                console.log(error);
            }

        }

        getTopFilms();

    }, []);

    return(
        <>
            {
            TopFilms.map((film, idx) => (<TopFilm film = {{...film,idx: idx}} key={film.id} onSelect={onSelect} />))
            }
        </>
    );
}


function TopFilm({film, onSelect}) {

    return (
        // TODO
        <div classNameName="row mb-5 pt-5 pb-5 bg-light">
            <div classNameName="col-md-6 mt-2 px-5 text-start order-2">
                <p className="display-4">{film.name}</p>
                <p className="lead">{(film.description.split(' ').slice(0, 32).join(' ')) + '...' }</p>
                <button className="btn btn-success" onClick={() => onSelect(films.)}>View</button>
            </div>
            <div className="col-md-6 text-center order-1">
                <img className="img-fluid img-thumbnail rounded-lg w-50" alt={ film.name} src={ film.image} />
            </div>
        </div>
    );
}

function FilmPage(selectedFilm){
    return(
        <>
            <p> Film is chosen</p>
        </>
    );
}
