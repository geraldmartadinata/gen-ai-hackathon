import { Sparkles, ArrowRight } from 'lucide-react';

export default function GeminiInsightsWidget({ onOpenModal }) {
  return (
    <div className="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-900/40 to-purple-900/20 border border-indigo-500/30 p-6 shadow-lg shadow-indigo-900/20 mb-8 group transition-all duration-300 hover:shadow-indigo-500/20">
      
      {/* Decorative blurred background elements */}
      <div className="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500 rounded-full blur-[100px] opacity-20 group-hover:opacity-30 transition-opacity"></div>
      <div className="absolute -bottom-24 -left-24 w-48 h-48 bg-purple-500 rounded-full blur-[100px] opacity-20 group-hover:opacity-30 transition-opacity"></div>
      
      <div className="relative z-10 flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
        <div className="flex-1 space-y-4">
          <div className="flex items-center gap-2">
            <Sparkles className="w-5 h-5 text-indigo-400" />
            <h2 className="text-lg font-semibold text-indigo-100">Vertex AI Inventory Insights</h2>
          </div>
          <p className="text-gray-300 leading-relaxed text-sm md:text-base">
            Based on the processed velocity of the last 30 days, <strong className="text-white">3 items</strong> are at critical risk of stockout. It is highly recommended to restock <strong className="text-white">'Item A'</strong> within 48 hours to prevent supply chain disruption.
          </p>
        </div>
        
        <button 
          onClick={onOpenModal}
          className="shrink-0 flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-indigo-500/25 focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        >
          Generate Restock Purchase Order
          <ArrowRight className="w-4 h-4" />
        </button>
      </div>
    </div>
  );
}
