import Authenticated from "@/Layouts/Authenticated/Index";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import Checkbox from "@/Components/Checkbox";
import PrimaryButton from "@/Components/PrimaryButton";
import { Head, useForm } from "@inertiajs/inertia-react";

export default function Create({ auth }) {
    const { setData, post, processing, errors } = useForm({
        name: "",
        category: "",
        video_url: "",
        thumbnail: "",
        rating: "",
        is_featured: false,
    });

    const handleOnChange = (event) => {
        setData(
            event.target.name,
            event.target.type == "file"
                ? event.target.files[0]
                : event.target.value
        );
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("admin.dashboard.movie.store"));
    };

    return (
        <>
            <Authenticated auth={auth}>
                <Head title="Admin-Create Movie" />
                <h1 className="text-xl">Insert New Movie</h1>
                <hr className="mb-7" />
                <form className="w-[400px]" onSubmit={submit}>
                    <div>
                        <InputLabel forInput="name" value=" Name" />
                        <TextInput
                            type="text"
                            name="name"
                            variant="primary-outline"
                            placeholder="Enter the Movie Name"
                            handleChange={handleOnChange}
                            isError={errors.name}
                        />
                        <InputError message={errors.name} className="mt-2" />
                    </div>
                    <div>
                        <InputLabel forInput="category" value="Category" />
                        <TextInput
                            type="text"
                            name="category"
                            variant="primary-outline"
                            placeholder="Enter the Movie Category"
                            handleChange={handleOnChange}
                            isError={errors.category}
                        />
                        <InputError
                            message={errors.category}
                            className="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel forInput="video_url" value="Video URL" />
                        <TextInput
                            type="url"
                            name="video_url"
                            variant="primary-outline"
                            placeholder="Enter the Movie video url"
                            handleChange={handleOnChange}
                            isError={errors.video_url}
                        />
                        <InputError
                            message={errors.video_url}
                            className="mt-2"
                        />
                    </div>
                    <div>
                        <InputLabel forInput="thumbnail" value="Thumbnail" />
                        <TextInput
                            type="file"
                            name="thumbnail"
                            variant="primary-outline"
                            placeholder="Insert the Movie Thumbnail"
                            handleChange={handleOnChange}
                            isError={errors.thumbnail}
                        />
                        <InputError
                            message={errors.thumbnail}
                            className="mt-2"
                        />
                    </div>

                    <div>
                        <InputLabel forInput="rating" value="Rating" />
                        <TextInput
                            type="number"
                            name="rating"
                            variant="primary-outline"
                            placeholder="Enter the Movie Rating"
                            handleChange={handleOnChange}
                            isError={errors.rating}
                        />
                        <InputError message={errors.rating} className="mt-2" />
                    </div>
                    <div className="flex flex-row mt-4 items-center">
                        <InputLabel
                            forInput="is_featured"
                            value="Is Featured"
                            className="mr-3 mt-1"
                        />
                        <Checkbox
                            name="is_featured"
                            handleChange={(e) =>
                                setData("is_featured", e.target.checked)
                            }
                        />
                    </div>
                    <PrimaryButton
                        type="submit"
                        className="mt-4"
                        processing={processing}
                    >
                        Save
                    </PrimaryButton>
                </form>
            </Authenticated>
        </>
    );
}
