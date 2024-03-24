import Authenticated from "@/Layouts/Authenticated/Index";
import SubcribtionCard from "@/Components/SubcribtionCard";
import { router } from "@inertiajs/react";

export default function SubcribtionPlan({ auth, subcribtionPlans }) {
    const selectSubcribtion = (id) => {
        router.post(
            route("user.dashboard.subcribtionPlan.userSubcribe", {
                subcribtionPlan: id,
            })
        );
    };
    return (
        <Authenticated auth={auth}>
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
                            key={subcribtionPlan.id}
                            name={subcribtionPlan.name}
                            price={subcribtionPlan.price}
                            durationInMonth={
                                subcribtionPlan.active_period_in_months
                            }
                            features={JSON.parse(subcribtionPlan.features)}
                            isPremium={subcribtionPlan.name == "Premium"}
                            onSelectSubribtion={() =>
                                selectSubcribtion(subcribtionPlan.id)
                            }
                        />
                    ))}
                </div>
            </div>
        </Authenticated>
    );
}
