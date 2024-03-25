import Authenticated from "@/Layouts/Authenticated/Index";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, Head } from "@inertiajs/inertia-react";
import FlashMessage from "@/Components/FlashMessage";

export default function Index({ auth, flashMessage }) {
    return (
        <>
            <Authenticated auth={auth}>
                <Head title="List of Movie" />
                <Link href={route("admin.dashboard.movie.create")}>
                    <PrimaryButton type="button" className="w-40 mb-8">
                        Insert New Movie
                    </PrimaryButton>
                </Link>
                {flashMessage?.message && (
                    <FlashMessage message={flashMessage.message} />
                )}
            </Authenticated>
        </>
    );
}
