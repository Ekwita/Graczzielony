export function formatMonth(dateStr: string, { capitalize = false }: { capitalize?: boolean } = {}): string {
    const formatted = new Intl.DateTimeFormat('pl-PL', { month: 'long', year: 'numeric' }).format(new Date(dateStr));

    if (!capitalize) {
        return formatted;
    }

    return formatted.charAt(0).toUpperCase() + formatted.slice(1);
}

export function useMonthFormatter() {
    return { formatMonth };
}
