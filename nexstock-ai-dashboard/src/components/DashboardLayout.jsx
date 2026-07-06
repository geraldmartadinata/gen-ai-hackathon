import Header from './Header';
import GeminiInsightsWidget from './GeminiInsightsWidget';
import TrendChartWidget from './TrendChartWidget';
import ThroughputWidget from './ThroughputWidget';
import StockRiskTable from './StockRiskTable';

export default function DashboardLayout({ onOpenModal }) {
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
      <Header />
      
      <main>
        <GeminiInsightsWidget onOpenModal={onOpenModal} />
        
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
          <div className="lg:col-span-2">
            <TrendChartWidget />
          </div>
          <div className="lg:col-span-1">
            <ThroughputWidget />
          </div>
        </div>
        
        <StockRiskTable onOpenModal={onOpenModal} />
      </main>
    </div>
  );
}
