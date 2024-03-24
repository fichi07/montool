import Authenticated from "@/Layouts/Authenticated/Index";
import FeaturedMovie from "@/Components/FeaturedMovie";
import MovieCard from "@/Components/MovieCard";
import Flickity from "react-flickity-component";
import { Link, Head } from "@inertiajs/inertia-react";
export default function Dashboard({ auth, featuresMovies, movies }) {
    const flickityOptions = {
        cellAlign: "left",
        contain: true,
        groupCells: 1,
        wrapAround: false,
        pageDots: false,
        prevNextButtons: false,
        draggable: ">1",
    };
    return (
        <Authenticated auth={auth}>
            <Head>
                <link
                    rel="stylesheet"
                    href="https://unpkg.com/flickity@2/dist/flickity.min.css"
                />
                <title>Dashboard</title>
            </Head>
            <div>
                <div className="font-semibold text-[22px] text-black mb-4">
                    Featured Movies
                </div>
                <Flickity className="gap-[30px]" options={flickityOptions}>
                    {featuresMovies.map((featuresMovies) => (
                        <FeaturedMovie
                            key={featuresMovies.id}
                            slug={featuresMovies.slug}
                            name={featuresMovies.name}
                            category={featuresMovies.category}
                            thumbnail={featuresMovies.thumbnail}
                            rating={featuresMovies.rating}
                        />
                    ))}
                </Flickity>
            </div>
            <div className="mt-[50px]">
                <div className="font-semibold text-[22px] text-black mb-4">
                    Browse
                </div>
                <Flickity className="gap-[30px]" options={flickityOptions}>
                    {movies.map((movies) => (
                        <MovieCard
                            key={movies.id}
                            slug={movies.slug}
                            name={movies.name}
                            thumbnail={movies.thumbnail}
                            category={movies.category}
                        />
                    ))}
                </Flickity>
            </div>
        </Authenticated>
    );
}
