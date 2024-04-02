import Authenticated from "@/Layouts/Authenticated/Index";
import SubcribtionCard from "@/Components/SubcribtionCard";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-react";

export default function SubcribtionPlan({ auth, subcribtionPlans, env }) {
    const selectSubcribtion = (id) => {
        Inertia.post(
            route("user.dashboard.subcribtionPlan.userSubcribe", {
                subcribtionPlan: id,
            }),
            {},
            {
                only: ["userSubcribtion"],
                onSuccess: ({ props }) => {
                    onSnapMidtrans(props.userSubcribtion);
                },
            }
        );
    };

    const onSnapMidtrans = (userSubcribtion) => {
        snap.pay(userSubcribtion.snap_token, {
            // Optional
            onSuccess: function (result) {
                Inertia.visit(route("user.dashboard.index"));
            },
            // Optional
            onPending: function (result) {
                console.log(result);
            },
            // Optional
            onError: function (result) {
                console.log(result);
            },
        });
    };
    return (
        <Authenticated auth={auth}>
            <Head title="Subcribtion Plan">
                <script
                    src="https://app.sandbox.midtrans.com/snap/snap.js"
                    data-client-key={env.MIDTRANS_CLIENTKEY}
                ></script>
            </Head>
            <div className="py-20 flex flex-col items-center">
                <div className="text-black font-semibold text-[26px] mb-3">
                    Pricing for Everyone
                </div>
                <p className="text-base text-gray-1 leading-7 max-w-[302px] text-center">
                    Invest your little money to get a whole new experiences from
                    movies.
                </p>

                <div className="flex justify-center gap-10 mt-[70px]">
                    {subcribtionPlans.map((subcribtionPlan) => (
                        <SubcribtionCard
                            name={subcribtionPlan.name}
                            price={subcribtionPlan.price}
                            durationInMonth={
                                subcribtionPlan.active_period_in_months
                            }
                            features={JSON.parse(subcribtionPlan.features)}
                            isPremium={subcribtionPlan.name == "Premium"}
                            key={subcribtionPlan.id}
                            onSelectSubcribtion={() =>
                                selectSubcribtion(subcribtionPlan.id)
                            }
                        />
                    ))}
                </div>
            </div>
        </Authenticated>
    );
}
